<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpEmployee;
use App\Models\Mrp\MrpShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MrpReportDeliveryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:report_delivery-list', ['only' => ['index']]);
        $this->middleware('permission:report_delivery-export', ['only' => ['create']]);
    }
    public function index()
    {
        $data['page_title'] = 'Delivery List';
        return view('mrp.delivery.report_delivery.report_delivery-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Shift Create';
        return view('mrp.shifts.shift-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shift_code' => 'required|unique:mrp_shifts|max:255',
            'shift_name' => 'required|max:255',
            'time_from' => 'required',
            'time_to' => 'required',
            'description' => 'nullable|min:3'
        ]);
        try {
            MrpShift::create([
                'shift_code' => $request->shift_code,
                'shift_name' => $request->shift_name,
                'time_from' => $request->time_from,
                'time_to' => $request->time_to,
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.shift-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.shift-list');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Shift Edit';
        $data['shift'] = MrpShift::find($id);
        return view('mrp.shifts.shift-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'shift_code' => "required|max:255|unique:mrp_shifts,shift_code,$id",
            'shift_name' => "required|max:255",
            'time_from' => 'required',
            'time_to' => 'required',
            'description' => "nullable|min:3"
        ]);
        try {
            MrpShift::where('id', $id)->update([
                'shift_code' => $request->shift_code,
                'shift_name' => $request->shift_name,
                'time_from' => $request->time_from,
                'time_to' => $request->time_to,
                'description' => $request->description


            ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('mrp.shift-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.shift-list');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success');
            MrpEmployee::where('shift_id', $request->id)->update(['shift_id' => null]);
            MrpShift::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger');
            //throw $th;
        }
    }
}
