<?php

namespace App\Http\Controllers\Mrp;

use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpUnit;
use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpMachine;
use App\Imports\UnitImport;
use App\Models\Mrp\MrpBomMaterial;
use App\Models\Mrp\MrpMaterial;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrpUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:unit-list', ['only' => ['index']]);
        $this->middleware('permission:unit-create', ['only' => ['create']]);
        $this->middleware('permission:unit-edit', ['only' => ['edit']]);
        $this->middleware('permission:unit-delete', ['only' => ['delete']]);

    }
    public function index()
    {
        $data['page_title'] = 'Unit List';
        $data['units'] = MrpUnit::orderBy('id', 'desc')->get();
        return view('mrp.units.unit-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Unit Create';
        return view('mrp.units.unit-create', $data);
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
            'unit_code' => 'required|max:255',
            'unit_name' => 'required|max:255',
            'description' => 'nullable'
        ]);
        try {
            MrpUnit::create([
                'unit_code' => $request->unit_code,
                'unit_name' => $request->unit_name,
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.unit-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.unit-list');
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
        $data['page_title'] = 'Unit Edit';
        $data['unit'] = MrpUnit::find($id);
        return view('mrp.units.unit-edit', $data);
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
            'unit_code' => "required|max:255",
            'unit_name' => "required|max:255",
            'description' => "nullable"
        ]);
        try {
            MrpUnit::where('id', $id)->update([
                'unit_code' => $request->unit_code,
                'unit_name' => $request->unit_name,
                'description' => $request->description


            ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('mrp.unit-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.unit-list');
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
            MrpProduct::where('unit_id', $request->id)->update(['unit_id' => null]);
            MrpMachine::where('unit_id', $request->id)->update(['unit_id' => null]);
            MrpBomMaterial::where('unit_id', $request->id)->update(['unit_id' => null]);
            MrpMaterial::where('unit_id', $request->id)->update(['unit_id' => null]);
            MrpUnit::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger');
            //throw $th;
        }
    }

    public function importUnit(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new UnitImport, $request->file('import_file')); 
                return back()->with(['success' => 'Import Unit Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        } 
    }
}
