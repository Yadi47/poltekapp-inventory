<?php

namespace App\Http\Controllers\Mrp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpBom;
use App\Models\Mrp\MrpBomMaterial;
use App\Models\Mrp\MrpInventoryMaterialList;
use App\Models\Mrp\MrpInventoryMaterialIncoming;
use App\Models\Mrp\MrpInventoryMaterialOut;
use App\Models\Mrp\MrpMaterial;
use App\Models\Mrp\MrpEmployee;
use App\Models\Mrp\MrpMachine;
use Illuminate\Support\Facades\DB;
use App\Models\Mrp\MrpUnit;
use Illuminate\Http\Request;

class MrpInventoryMaterialOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'Material Outgoing';
        $data['material_outs'] = MrpInventoryMaterialOut::orderBy('id', 'desc')->get();
        return view('mrp.inventories.materials.stock-out.material-out-list', $data);
    }

    public function conveyorProduction(Request $request)
    {
        $data['page_title'] = 'Material Outgoing';
        $data['material_outs'] = MrpInventoryMaterialOut::orderBy('id', 'desc')->get();
        return view('mrp.dashboard.conveyor-production.conveyor_production-list', $data);
    }

    public function indexSortir()
    {
        $data['page_title'] = 'Material Outgoing Sortir';
        
        $data['material_incomings'] = MrpInventoryMaterialIncoming::orderBy('id','desc')->get();

        return view('mrp.inventories.materials.stock-out.material-out-sortir', $data);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Material Outgoing Create';
        $data['materials'] = MrpMaterial::get();
        $data['employees'] = MrpEmployee::get();
        $data['machines'] = MrpMachine::get();
        $data['inven_material_list'] = MrpInventoryMaterialList::get();
        // dd($data['inven_material_incoming']);
        return view('mrp.inventories.materials.stock-out.material-out-create', $data);
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
            'inventory_material_list_id' => 'required',
            'material_outgoing' => 'required',
            'employee_id' => 'required',
            // 'machine_id' => 'required',
            'current_stock' => 'nullable',
            'description' => 'nullable'
        ],
    [
        'inventory_material_list_id.required' => '*Part Name Wajib Diisi!',
        'material_outgoing.required' => '*Qty Out Wajib Diisi!',
        'employee_id.required' => '*PIC Wajib Diisi!',
        'machine_id.required' => '*Machine Wajib Diisi!',
    ]);
        // dd($request->all());
        try {
            MrpInventoryMaterialList::where('id',$request->inventory_material_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpInventoryMaterialOut::create([
                'inventory_material_list_id' => $request->inventory_material_list_id,
                'material_outgoing' => $request->material_outgoing,
                'employee_id' => $request->employee_id,
                'current_stock' => $request->current_stock,
                // 'machine_id' => $request->machine_id,
                'description' => $request->description
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.material-out-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.material-out-list');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Material Outgoing Edit';
        $data['materials'] = MrpMaterial::get();
        $data['employees'] = MrpEmployee::get();
        $data['machines'] = MrpMachine::get();
        $data['inven_material_list'] = MrpInventoryMaterialList::get();
        $data['material_out'] = MrpInventoryMaterialOut::find($id);
        return view('mrp.inventories.materials.stock-out.material-out-edit', $data);
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
            'inventory_material_list_id' => 'required',
            'material_outgoing' => 'required',
            'employee_id' => 'required',
            // 'machine_id' => 'required',
            'current_stock' => 'nullable',
            'description' => 'nullable'
            
        ],
    [
        'inventory_material_list_id.required' => '*Part Name Wajib Diisi!',
        'material_outgoing.required' => '*Qty Out Wajib Diisi!',
        'employee_id.required' => '*PIC Wajib Diisi!',
        'machine_id.required' => '*Machine Wajib Diisi!',
    ]);

        try {
            
            MrpInventoryMaterialList::where('id',$request->inventory_material_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpInventoryMaterialOut::where('id',$id)->update([
                'inventory_material_list_id' => $request->inventory_material_list_id,
                'material_outgoing' => $request->material_outgoing,
                'employee_id' => $request->employee_id,
                'current_stock' => $request->current_stock,
                // 'machine_id' => $request->machine_id,
                'description' => $request->description

                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.material-out-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.material-out-list');
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
            $inventoryMaterialOut = MrpInventoryMaterialOut::findOrFail($request->id);
            $inventoryMaterialList = MrpInventoryMaterialList::findOrFail($inventoryMaterialOut->inventory_material_list_id);
            $inventoryMaterialList->stock = $inventoryMaterialList->stock + $inventoryMaterialOut->material_outgoing;
            $inventoryMaterialList->save();
            $inventoryMaterialOut->delete();
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

    public function createOut()
    {
        $data['employees'] = MrpEmployee::get();
        $data['machines'] = MrpMachine::get();
        return view('mrp.inventories.materials.stock-out.material-out-create-api', $data);
    }

    public function storeOut(Request $request)
    {
        try {
            MrpInventoryMaterialList::where('id', $request->material_list_id)->update([
                'stock' => $request->current_stock
            ]);

            $insertOut = [
                'inventory_material_list_id' => $request->material_list_id,
                'material_id' => $request->material_id,
                'material_outgoing' => $request->material_outgoing,
                'employee_id' => $request->employee_id,
                'machine_id' => $request->machine_id,
                'current_stock' => $request->current_stock,
                'description' => $request->description ?? 'N/A',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            DB::table('mrp_inventory_material_out')->insert($insertOut);

            $response = (object)[
                'status' => 200,
                'message' => "Succes Insert"
            ];
            return json_encode($response);
        } catch (\Throwable $th) {
            $response = (object)[
                'status' => 500,
                'message' => $th->getMessage()
            ];
            return json_encode($response);
        }
    }
}
