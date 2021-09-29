<?php

namespace App\Http\Controllers\Mrp;
use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpShift;
use App\Models\Mrp\MrpEmployee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrpShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:shift-list', ['only' => ['index']]);
        $this->middleware('permission:shift-create', ['only' => ['create']]);
        $this->middleware('permission:shift-edit', ['only' => ['edit']]);
        $this->middleware('permission:shift-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Shift List';
        $data['shifts'] = MrpShift::orderBy('id','asc')->get();
        return view('mrp.shifts.shift-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Shift Create';
        return view('mrp.shifts.shift-create',$data);
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
            'total_time' => 'required',
            'running_operation' => 'nullable',
            'status' => 'nullable',
            'description' => 'nullable'
        ]);
        try {
            MrpShift::create([
                'shift_code' => $request->shift_code,
                'shift_name' => $request->shift_name,
                'time_from' => $request->time_from,
                'time_to' => $request->time_to,
                'over_night' => $request->over_night,
                'total_time' => $request->total_time,
                'running_operation' => $request->running_operation,
                'status' => $request->status,
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
        return view('mrp.shifts.shift-edit',$data);
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
            'total_time' => 'required',
            'running_operation' => 'nullable',
            'status' => 'required',
            'description' => "nullable"
        ]);
        try {
            MrpShift::where('id',$id)->update([
                'shift_code' => $request->shift_code,
                'shift_name' => $request->shift_name,
                'time_from' => $request->time_from,
                'time_to' => $request->time_to,
                'total_time' => $request->total_time,
                'over_night' => $request->over_night,
                'running_operation' => $request->running_operation,
                'status' => $request->status,
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
