<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpInventoryMaterialOut;
use App\Models\Mrp\MrpMaterial;
use App\Models\Mrp\MrpEmployee;
use App\Models\Mrp\MrpInventoryMaterialList;
use App\Models\Mrp\MrpMaterialSortir;
use App\Models\Mrp\MrpMaterialSortirOk;
use App\Models\Mrp\MrpMaterialSortirNG;
use Illuminate\Http\Request;

class MrpMaterialSortirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Material Recheck ';
        $data['material_sortirs'] = MrpMaterialSortir::orderBy('id', 'desc')->get();
        return view('mrp.inventories.materials.stock-out.sortir.material-sortir-list', $data);
    }

    public function indexSortirOK()
    {
        $data['page_title'] = 'Material Recheck OK';
        $data['material_sortir_ok'] = MrpMaterialSortirOK::orderBy('id', 'desc')->get();
        return view('mrp.inventories.materials.stock-out.sortir.material-sortir-ok-list', $data);
    }

    public function indexSortirNG()
    {
        $data['page_title'] = 'Material Recheck NG';
        $data['material_sortir_ng'] = MrpMaterialSortirNG::orderBy('id', 'desc')->get();
        return view('mrp.inventories.materials.stock-out.sortir.material-sortir-ng-list', $data);
    }

        public function totalSortir()
        {
            $data['page_title'] = 'Material Recheck ';
            $data['material_sortirs'] = MrpMaterialSortir::orderBy('id', 'desc')->get();
            return view('mrp.dashboard.total-sortir.total_sortir-list', $data);
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    public function totalOkSortir()
    {
        $data['page_title'] = 'Material Recheck OK List';
        $data['material_sortirs'] = MrpMaterialSortirOk::orderBy('id', 'desc')->get();
        // dd($data['material_sortirs']);
        return view('mrp.dashboard.sortir-ok.sortir_ok-list', $data);
    }

    public function totalNgSortir()
    {
        $data['page_title'] = 'Material Recheck NG List';
        $data['material_sortirs'] = MrpMaterialSortirNg::orderBy('id', 'desc')->get();
        // dd($data['material_sortirs']);
        return view('mrp.dashboard.sortir-ng.sortir_ng-list', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Material Recheck Create';
        $data['inven_materials'] = MrpInventoryMaterialList::get();
        $data['employees'] = MrpEmployee::get();
        return view('mrp.inventories.materials.stock-out.sortir.material-sortir-create', $data);
    }

    public function createSortirOK()
    {
        $data['page_title'] = 'Material Recheck OK Create';
        $data['inven_materials'] = MrpInventoryMaterialList::get();
        $data['employees'] = MrpEmployee::get();
        return view('mrp.inventories.materials.stock-out.sortir.material-sortir-ok-create', $data);
    }

    public function createSortingNG()
    {
        $data['page_title'] = 'Material Recheck NG Create';
        $data['inven_materials'] = MrpInventoryMaterialList::get();
        $data['employees'] = MrpEmployee::get();
        return view('mrp.inventories.materials.stock-out.sortir.material-sortir-ng-create', $data);
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
            'qty_sortir' => 'nullable',
            'current_stock' => 'nullable',
            'employee_id' => 'required',
            'description' => 'nullable'
        ],
    [
        'inventory_material_list_id.required' => '*Material Wajib Diisi!',
        'employee_id.required' => '*PIC Wajib Diisi!',
    ]);
        try {
            MrpInventoryMaterialList::where('id',$request->inventory_material_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpMaterialSortir::create([
                'inventory_material_list_id' => $request->inventory_material_list_id,
                'qty_sortir' => $request->qty_sortir,
                'qty_ok' => $request->qty_ok,
                'qty_ng' => $request->qty_ng,
                'current_stock' => $request->current_stock,
                'employee_id' => $request->employee_id,
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.material-sortir-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.material-sortir-list');
        }
    }

    public function storeSortirOK(Request $request)
    {
        $validated = $request->validate([
            'inventory_material_list_id' => 'required',
            'qty_ok' => 'nullable',
            'employee_id' => 'required',
            'date' => 'nullable',
            'description' => 'nullable'
        ],
        [
            'inventory_material_list_id.required' => '*Material Wajib Diisi!',
            'employee_id.required' => '*PIC Wajib Diisi!',
        ]);
        try {
            MrpInventoryMaterialList::where('id',$request->inventory_material_list_id)->update([
                'stock' => $request->current_stock
            ]);
            
            MrpMaterialSortirOk::create([
                'inventory_material_list_id' => $request->inventory_material_list_id,
                'qty_ok' => $request->qty_ok,
                'current_stock' => $request->current_stock,
                'employee_id' => $request->employee_id,
                'date' => date('Y-m-d', strtotime($request->date)),
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.material-sortir-list-sortir-ok');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.material-sortir-list-sortir-ok');
        }
    }

    public function storeSortirNG(Request $request)
    {
        $validated = $request->validate([
            'inventory_material_list_id' => 'required',
            'qty_ng' => 'nullable',
            'employee_id' => 'required',
            'date' => 'nullable',
            'description' => 'nullable'
        ],
        [
            'inventory_material_list_id.required' => '*Material Wajib Diisi!',
            'employee_id.required' => '*PIC Wajib Diisi!',
        ]);
        try {
            MrpMaterialSortir::where('id',$request->inventory_material_list_id)->update([
                'qty_ng' => $request->qty_ng
            ]);
            MrpMaterialSortirNG::create([
                'inventory_material_list_id' => $request->inventory_material_list_id,
                'qty_ng' => $request->qty_ng,
                'employee_id' => $request->employee_id,
                'date' => date('Y-m-d', strtotime($request->date)),
                'description' => $request->description
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.material-sortir-list-sortir-ng');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.material-sortir-list-sortir-ng');
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
        $data['page_title'] = 'Material Recheck Edit';
        $data['inven_materials'] = MrpInventoryMaterialList::get();
        $data['employees'] = MrpEmployee::get();
        $data['material_sortir'] = MrpMaterialSortir::findOrFail($id);
        return view('mrp.inventories.materials.stock-out.sortir.material-sortir-edit', $data);

    }

    public function editSortirOK($id)   
    {
        $data['page_title'] = 'Material Recheck OK Edit';
        $data['inven_materials'] = MrpInventoryMaterialList::get();
        $data['employees'] = MrpEmployee::get();
        $data['material_sortir_ok'] = MrpMaterialSortirOK::findOrFail($id);
        return view('mrp.inventories.materials.stock-out.sortir.material-sortir-ok-edit', $data);

    }

    public function editSortirNG($id)   
    {
        $data['page_title'] = 'Material Recheck NG Edit';
        $data['inven_materials'] = MrpInventoryMaterialList::get();
        $data['employees'] = MrpEmployee::get();
        $data['material_sortir_ng'] = MrpMaterialSortirNG::findOrFail($id);
        return view('mrp.inventories.materials.stock-out.sortir.material-sortir-ng-edit', $data);

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
            'current_stock' => 'nullable',
            'employee_id' => 'required',
            'description' => 'nullable'
        ],
        [
            'inventory_material_list_id.required' => '*Material Wajib Diisi!',
            'employee_id.required' => '*PIC Wajib Diisi!',
        ]);
        try {
            MrpInventoryMaterialList::where('id',$request->inventory_material_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpMaterialSortir::where('id',$id)->update([
                'inventory_material_list_id' => $request->inventory_material_list_id,
                'qty_ok' => $request->qty_ok,
                'qty_ng' => $request->qty_ng,
                'current_stock' => $request->current_stock,
                'employee_id' => $request->employee_id,
                'description' => $request->description

                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.material-sortir-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.material-sortir-list');
        }
    }

    public function updateSortirOK(Request $request, $id)
    {
        $validated = $request->validate([
            'inventory_material_list_id' => 'required',
            'qty_ok' => 'nullable',
            'employee_id' => 'required',
            'date' => 'nullable',
            'description' => 'nullable'
        ],
        [
            'inventory_material_list_id.required' => '*Material Wajib Diisi!',
            'employee_id.required' => '*PIC Wajib Diisi!',
        ]);
        try {
            MrpInventoryMaterialList::where('id',$request->inventory_material_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpMaterialSortirOK::where('id',$id)->update([
                'inventory_material_list_id' => $request->inventory_material_list_id,
                'qty_ok' => $request->qty_ok,
                'current_stock' => $request->current_stock,
                'employee_id' => $request->employee_id,
                'date' => date('Y-m-d', strtotime($request->date)),
                'description' => $request->description

                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.material-sortir-list-sortir-ok');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.material-sortir-list-sortir-ok');
        }
    }

    public function updateSortirNG(Request $request, $id)
    {
        $validated = $request->validate([
            'inventory_material_list_id' => 'required',
            'current_stock' => 'nullable',
            'employee_id' => 'required',
            'description' => 'nullable'
        ],
        [
            'inventory_material_list_id.required' => '*Material Wajib Diisi!',
            'employee_id.required' => '*PIC Wajib Diisi!',
        ]);
        try {
            MrpInventoryMaterialList::where('id',$request->inventory_material_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpMaterialSortirNG::where('id',$id)->update([
                'inventory_material_list_id' => $request->inventory_material_list_id,
                'qty_ng' => $request->qty_ng,
                'employee_id' => $request->employee_id,
                'date' => date('Y-m-d', strtotime($request->date)),
                'description' => $request->description

                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.material-sortir-list-sortir-ng');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.material-sortir-list-sortir-ng');
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
            MrpMaterialSortir::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }

    public function destroySortirOK(Request $request)
    {
        try {
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success'); 
            MrpMaterialSortirOK::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }
    public function destroySortirNG(Request $request)
    {
        try {
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success'); 
            MrpMaterialSortirNG::destroy($request->id);
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
