<?php

namespace App\Http\Controllers\Mrp;

use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpBom;
use App\Models\Mrp\MrpMaterial;
use App\Models\Mrp\MrpInventoryMaterialList;
use App\Models\Mrp\MrpUnit;
use App\Models\Mrp\MrpBomMaterial;
use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpProduct;
use Illuminate\Http\Request;
use DB;

class MrpBomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bom-list', ['only' => ['index']]);
        $this->middleware('permission:bom-create', ['only' => ['create']]);
        $this->middleware('permission:bom-edit', ['only' => ['edit']]);
        $this->middleware('permission:bom-delete', ['only' => ['destroy']]);
        $this->middleware('permission:bom-show', ['only' => ['show']]);
    }
    public function index()
    {
        $data['page_title'] = 'BOM List';
        $data['boms'] = MrpBom::orderBy('id', 'desc')->get();
        return view('mrp.boms.bom-list', $data);
    }

    public function report()
    {
        $data['page_title'] = 'BOM Report List';
        $data['reports'] = MrpBom::get();
        return view('mrp.boms.bom-report', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'BOM Create';
        $data['inventory_materials'] = MrpInventoryMaterialList::get();
        $data['units'] = MrpUnit::get();
        $data['products'] = MrpProduct::get();

        return view('mrp.boms.bom-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'bom_code' => 'required|max:255',
            'bom_name' => 'required|max:255',
            'material_id' => 'required',
            'qty_material' => 'nullable',
            'unit_id' => 'required',
            'description' => 'nullable',
            'product_id' =>'nullable'
        ]);
        // try {

        // dd($request->get('material_id'));
        DB::beginTransaction();
        try {
            
            
            $bom = MrpBom::create([
                'bom_code' => $request->bom_code,
                'bom_name' => $request->bom_name,
                'description' => $request->description,
            ]);

            // foreach ($request->product_id as $prodId) {
            //     MrpProduct::where('id',$prodId)->update(['bom_id'=>$bom->id]);
            // }
            $materialInserts = [];
            if ($request->get('material_id')) {
                foreach ($request->get('material_id') as $key => $value) {
                    array_push($materialInserts, [
                        'bom_id' => $bom->id,
                        'material_id' => $request->get('material_id')[$key],
                        'qty_material' => $request->get('qty_material')[$key],
                        'created_at' => date('Y-m-d H:i:s'),
                        'unit_id' => $request->get('unit_id')[$key],
                    ]);

                    
                    //proses pengurangan stock di inventory product list
                    // $inventoryMaterialList = MrpInventoryMaterialList::findOrFail($request->get('material_id')[$key]);
                    // $inventoryMaterialList->stock = $inventoryMaterialList->stock - $request->get('qty_material')[$key];
                    // $inventoryMaterialList->save();

                }
                DB::table('mrp_bom_materials')->insert($materialInserts);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }

        Session::flash('message', 'Data Successfuly created !');
        Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
        return redirect()->route('mrp.bom-list');
        // } catch (\Throwable $th) {
        //     Session::flash('message', $th->getMessage());
        //     Session::flash('alert-class', 'alert-danger'); 
        //     return redirect()->route('mrp.bom-list');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['bom'] = MrpBom::findOrFail($id);

        return view('mrp.boms.bom-show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'BOM Edit';
        $data['inventory_materials'] = MrpInventoryMaterialList::get();
        $data['units'] = MrpUnit::get();
        $data['products'] = MrpProduct::get();

        $data['bom'] = MrpBom::find($id);
        $data['bom_materials'] = MrpBomMaterial::where('bom_id',$id)->get();
        $data['bom_products'] = $data['bom']->products->pluck('id')->toArray();

        return view('mrp.boms.bom-edit', $data);

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
            'bom_code' => 'required',
            'bom_name' => 'required|max:255',
            // 'part_name' => 'required',
            'material_id' => 'required',
            'qty_material' => 'nullable',
            'unit_id' => 'required',
            'description' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            $bom = MrpBom::find($id);


            $bom->update([
                'bom_code' => $request->bom_code,
                'bom_name' => $request->bom_name,
                // 'part_name' => $request->part_name,
                // 'part_number' => $request->part_number,
                'description' => $request->description,
            ]);

            foreach ($request->product_id as $prodId) {
                MrpProduct::where('id',$prodId)->update(['bom_id'=>$id]);
            }
            $BomMaterials = DB::table('mrp_bom_materials')
                    ->where('bom_id',$id)->get();
            $materialInserts = [];

            // cek ada yang di delete gak
            
            foreach ($BomMaterials as $bms) {
                // dd(in_array((string)$bms->id, $request->get('id')));
                
                if(!in_array((string)$bms->id,$request->get('id'))){
                    DB::table('mrp_bom_materials')
                        ->where('id', $bms->id)
                        ->delete();
                        
                }
            }
            if ($request->get('material_id')) {
                foreach ($request->get('material_id') as $key => $value) {
                    // $checkBomMaterial = DB::table('mrp_bom_materials')
                    // ->where('bom_id',$id)
                    // ->where('material_id',$request->get('material_id')[$key]) 
                    // ->where('qty_material',($request->get('qty_old')[$key] != "" ?$request->get('qty_old')[$key]: $request->get('qty_material')[$key])) 
                    // ->where('unit_id',($request->get('unit_id_old')[$key] != "" ?$request->get('unit_id_old')[$key] :$request->get('unit_id')[$key]))->count();
                    
                    
                    if($request->get('action')[$key]==='update'){
                        DB::table('mrp_bom_materials')
                        ->where('id',$request->get('id')[$key])
                        ->update([
                            'bom_id' => $bom->id,
                            'material_id' => $request->get('material_id')[$key],
                            'qty_material' => $request->get('qty_material')[$key],
                            'unit_id' => $request->get('unit_id')[$key]
                        ]);
                    }else{
                        array_push($materialInserts, [
                            'bom_id' => $bom->id,
                            'material_id' => $request->get('material_id')[$key],
                            'qty_material' => $request->get('qty_material')[$key],
                            'unit_id' => $request->get('unit_id')[$key],
                        ]);
                    }

                  
                }
                // dd($request->get('qty_old')[$key]);

                if(count($materialInserts)>0){
                    DB::table('mrp_bom_materials')->insert($materialInserts);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }
        Session::flash('message', 'Data Successfuly Updated !');
        Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
        return redirect()->route('mrp.bom-list');
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
            MrpBomMaterial::where('bom_id', $request->id)->update(['bom_id' => null]);
            MrpProduct::where('bom_id', $request->id)->update(['bom_id' => null]);
            MrpBom::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger');
            //throw $th;
        }
    }

    public function getMaterialById($id)
    {
        $data = MrpBomMaterial::find($id);
        return $data;

    }
}
