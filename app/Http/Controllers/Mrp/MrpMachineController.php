<?php

namespace App\Http\Controllers\Mrp;

use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpMachine;
use App\Models\Mrp\MrpPlace;
use App\Models\Mrp\MrpUnit;
use App\Models\Mrp\MrpProcess;
use App\Models\Mrp\MrpSupplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrpMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:machine-list', ['only' => ['index']]);
        $this->middleware('permission:machine-create', ['only' => ['create']]);
        $this->middleware('permission:machine-edit', ['only' => ['edit']]);
        $this->middleware('permission:machine-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Machine List';
        $data['machines'] = MrpMachine::orderBy('id', 'desc')->get();
        return view('mrp.machines.machine-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Machine Create';
        $data['units'] = MrpUnit::get();
        $data['places'] = MrpPlace::get();
        $data['suppliers'] = MrpSupplier::get();

        return view('mrp.machines.machine-create', $data);
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
            'machine_code' => 'required|max:255',
            'machine_name' => 'required|max:255',
            'type' => 'nullable|max:255',
            'brand' => 'nullable|max:255',
            'capacity' => 'nullable',
            'unit_id' => 'nullable',
            'place_id' => 'nullable',
            'supplier_id' => 'nullable',
            'description' => 'nullable'
        ]);
        try {
            MrpMachine::create([
                'machine_code' => $request->machine_code,
                'machine_name' => $request->machine_name,
                'type' => $request->type,
                'brand' => $request->brand,
                'capacity' => $request->capacity ?? 0,
                'unit_id' => $request->unit_id,
                'place_id' => $request->place_id,
                'supplier_id' => $request->supplier_id,
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.machine-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.machine-list');
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
        $data['page_title'] = 'Machine Edit';
        $data['units'] = MrpUnit::get();
        $data['places'] = MrpPlace::get();
        $data['suppliers'] = MrpSupplier::get();
        $data['machine'] = MrpMachine::find($id);
        return view('mrp.machines.machine-edit', $data);
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
            'machine_code' => "required|max:255",
            'machine_name' => "required|max:255",
            'type' => 'nullable|max:255',
            'brand' => 'nullable|max:255',
            'capacity' => 'nullable',
            'unit_id' => 'nullable',
            'place_id' => 'nullable',
            'supplier_id' => 'nullable',
            'description' => "nullable"
        ]);
        try {
            MrpMachine::where('id', $id)->update([
                'machine_code' => $request->machine_code,
                'machine_name' => $request->machine_name,
                'type' => $request->type,
                'brand' => $request->brand,
                'capacity' => $request->capacity,
                'unit_id' => $request->unit_id,
                'place_id' => $request->place_id,
                'supplier_id' => $request->supplier_id,
                'description' => $request->description
            ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('mrp.machine-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.machine-list');
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
            MrpProcess::where('machine_id', $request->id)->update(['machine_id' => null]);
            MrpMachine::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger');
            //throw $th;
        }
    }
}
