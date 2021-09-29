<?php

namespace App\Http\Controllers\Mrp;

use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpInventoryMaterialList;
use App\Models\Mrp\MrpInventoryMaterialIncoming;
use App\Models\Mrp\MrpMaterial;
use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpBom;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class MrpInventoryMaterialListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:inventory_material_index-list', ['only' => ['index']]);
        $this->middleware('permission:inventory_material_index-create', ['only' => ['create']]);
        $this->middleware('permission:inventory_material_index-edit', ['only' => ['edit']]);
        $this->middleware('permission:inventory_material_index-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Material List';
        $data['inven_materials'] = MrpInventoryMaterialList::orderBy('id','desc')->get();
        $data['inven_material_incomings'] = MrpInventoryMaterialIncoming::orderBy('id','desc')->get();
        return view('mrp.inventories.materials.list-material.material-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Inventory Material Create';
        $data['materials'] = MrpMaterial::get();
        return view('mrp.inventories.materials.list-material.material-create', $data);
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
            'material_id' => 'required',
            'initial_stock' => 'nullable',
            'stock' => 'nullable',
            'lot_material' => 'nullable',
            'description' => 'nullable'
        ],
    [
        'material_id.required' => '*Material Wajib Diisi!'
    ]);
        try {
            MrpInventoryMaterialList::create([
                'material_id' => $request->material_id,
                'initial_stock' => $request->initial_stock,
                'stock' => $request->initial_stock,
                'qty_target' => $request->qty_target,
                'target_day' => $request->target_day,
                'target_min' => $request->target_min,
                'target_max' => $request->target_max,
                'total_target_day' => $request->total_target_day,
                'lot_material' => date('Y-m-d', strtotime($request->lot_material)),
                'description' => $request->description
            ]);

            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.inventory_material-list');
        } catch (\Throwable $th) {
           
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.inventory_material-list');
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
        $data['page_title'] = 'Inventory Material Edit';
        $data['materials'] = MrpMaterial::get();
        $data['inven_material'] = MrpInventoryMaterialList::find($id);
        return view('mrp.inventories.materials.list-material.material-edit', $data);
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
        // dd($request->all());
        $validated = $request->validate([
            'material_id' => 'required',
            'initial_stock' => 'nullable',
            'stock' => 'nullable',
            'lot_material' => 'nullable',
            'description' => 'nullable'
        ],
    [
        'material_id.required' => '*Material Wajib Diisi!'
    ]);
        
        try {
            MrpInventoryMaterialList::where('id',$id)->update([
                'material_id' => $request->material_id,
                'initial_stock' => $request->initial_stock,
                'stock' => $request->initial_stock,
                'qty_target' => $request->qty_target,
                'target_day' => $request->target_day,
                'target_min' => $request->target_min,
                'target_max' => $request->target_max,
                'total_target_day' => $request->total_target_day,
                'lot_material' => date('Y-m-d', strtotime($request->lot_material)),
                'description' => $request->description

            ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('mrp.inventory_material-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.inventory_material-list');
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
            MrpBom::where('material_id', $request->id)->update(['material_id' => null]);
            MrpInventoryMaterialList::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }

    public function getInventoryMaterialListById($id)
    {
        $inventory_material = MrpInventoryMaterialList::find($id);
        return $inventory_material;
    }
}

