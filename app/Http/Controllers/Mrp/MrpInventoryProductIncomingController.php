<?php

namespace App\Http\Controllers\Mrp;

use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpInventoryProductIncoming;
use App\Models\Mrp\MrpInventoryProductList;
use App\Models\Mrp\MrpProductionProcessMachineProduct;
use App\Models\Mrp\MrpEmployee;
use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpProduction;
use App\Models\Mrp\MrpMachine;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrpInventoryProductIncomingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:inventory_product_incoming-list', ['only' => ['index']]);
        $this->middleware('permission:inventory_product_incoming-create', ['only' => ['create']]);
        $this->middleware('permission:inventory_product_incoming-edit', ['only' => ['edit']]);
        $this->middleware('permission:inventory_product_incoming-delete', ['only' => ['destroy']]);
    }

    public function index()
    {

        // -- ambil stock in product
        // $machineProcess = MrpInventoryProductList::where('product_id', 3)->get();
        // $data['qty_good'] = 0;
        // $data = $machineProcess->current_stock;
        //     $machineProcess = MrpProductionProcessMachineProduct::where('product_id', 3)->get();

        // $productiStockIn = 0;
        // foreach ($machineProcess as $key => $value) {
        //     $productStockIn += $value->ProductInWip->sum('qty_good');

        // }
        // dd($productiStockIn);
        // return $data;



        // $machineProcess = MrpProductionProcessMachineProduct::where('product_id', 3)->get();
        //     $data['qty_good'] = 0;
        //     $data['current_stock'] = $machineProcess->product->inventoryProductList->current_stock;

        // return $data;

        $data['page_title'] = 'Inventory Product Incoming';
        $data['product_incomings'] = MrpInventoryProductIncoming::orderBy('id', 'desc')->get();
        return view('mrp.inventories.products.product-incoming.product-incoming-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Inventory Product Incoming Create';
        $data['products'] = MrpProduct::get();
        $data['productions'] = MrpProduction::get();
        $data['employees'] = MrpEmployee::get();
        $data['inven_product_list'] = MrpInventoryProductList::get();
        $data['machines'] = MrpMachine::get();

        return view('mrp.inventories.products.product-incoming.product-incoming-create', $data);
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
            'inventory_product_list_id' => 'required',
            'product_incoming' => 'required',
            'employee_id' => 'required',
            'current_stock' => 'nullable',
            // 'sortir' => 'nullable',
            'description' => 'nullable'
        ], 
        [
            'inventory_product_list_id.required' => '*Part Name Wajib Diisi!',
            'product_incoming.required' => '*Product Incoming Wajib Diisi!',
            'employee_id.required' => '*PIC Wajib Diisi!',
        ]);
        try {
            MrpInventoryProductList::where('id', $request->inventory_product_list_id)->update([
                'stock' => $request->current_stock
            ]);

            MrpInventoryProductIncoming::create([
                'inventory_product_list_id' => $request->inventory_product_list_id,
                'product_incoming' => $request->product_incoming,
                'employee_id' => $request->employee_id,
                // 'machine_id' => $request->machine_id,
                'current_stock' => $request->current_stock,
                // 'sortir' => $request->sortir,
                'description' => $request->description,
                // 'mrp_inventory_product_list_id' => $request->pdl_id,
            ]);

            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.product-incoming-list');
        } catch (\Throwable $th) {

            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.product-incoming-list');
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
        $data['page_title'] = 'Inventory Product Incoming Edit';
        $data['products'] = MrpProduct::get();
        $data['employees'] = MrpEmployee::get();
        $data['inven_product_list'] = MrpInventoryProductList::get();
        $data['product_incoming'] = MrpInventoryProductIncoming::find($id);
        $data['machines'] = MrpMachine::get();
        return view('mrp.inventories.products.product-incoming.product-incoming-edit', $data);
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
            'inventory_product_list_id' => "required",
            'product_incoming' => "required",
            'employee_id' => "required",
            'current_stock' => "nullable",
            'description' => "nullable"
        ],
    [
            'inventory_product_list_id.required' => '*Part Name Wajib Diisi!',
            'product_incoming.required' => '*Product Incoming Wajib Diisi!',
            'employee_id.required' => '*PIC Wajib Diisi!',
    ]);

        try {
            MrpInventoryProductList::where('id', $request->inventory_product_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpInventoryProductIncoming::where('id', $id)->update([
                'inventory_product_list_id' => $request->inventory_product_list_id,
                'product_incoming' => $request->product_incoming,
                'employee_id' => $request->employee_id,
                // 'machine_id' => $request->machine_id,
                'current_stock' => $request->current_stock,
                'description' => $request->description


            ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('mrp.product-incoming-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.product-incoming-list');
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
            $inventoryProductIncoming = MrpInventoryProductIncoming::findOrFail($request->id);

            $inventoryProductList = MrpInventoryProductList::findOrFail($inventoryProductIncoming->inventory_product_list_id);
            $inventoryProductList->stock = $inventoryProductList->stock - $inventoryProductIncoming->product_incoming;
            $inventoryProductList->save();
            $inventoryProductIncoming->delete();
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger');
            //throw $th;
        }
    }

    public function getInventoryProductListById($id)
    {
        $inven = MrpInventoryProductList::find($id);
        return $inven;
    }

    public function getProductionQty($id)
    {
        // -- ambil stock in product
        // $machineProcess = MrpInventoryProductList::where('product_id', $id)->get();
        // $data['qty_good'] = 0;
        // $data['current_stock'] = $machineProcess->product->current_stock;
        // $productiStockIn = 0;
        // foreach ($machineProcess as $key => $value) {
        //     $productStockIn += $value->ProductInWip->sum('qty_good');
        //     $value->
        // }
        // dd($productiStockIn);
        // return $productStockIn;

        $machineProcess = MrpProductionProcessMachineProduct::where('product_id', $id)->get();
        $currentStock = MrpInventoryProductList::where('product_id', $id)->get();
        $data['incoming'] = 0;
        $data['current'] = 0;
        foreach ($machineProcess as $key => $value) {
            $data['incoming'] += $value->ProductInWip->sum('qty_good');
            // $data['incoming'] += $machineProcess->product->current_stock;
            // $data['current'] += $machineProcess->product->current_stock;
        }

        foreach ($currentStock as $val) {
            $data['current'] = $val->sum('stock');
        }


        return $data;
    }

    public function createIncoming()
    {
        $data['employees'] = MrpEmployee::get();
        $data['machines'] = MrpMachine::get();
        return view('mrp.inventories.products.product-incoming.product-incoming-create-api', $data);
    }

    public function storeIncoming(Request $request)
    {
        try {
            MrpInventoryProductList::where('id', $request->product_list_id)->update([
                'stock' => $request->current_stock
            ]);

            $insertIncoming = [
                'inventory_product_list_id' => $request->product_list_id,
                'product_incoming' => $request->product_incoming,
                'employee_id' => $request->employee_id,
                'machine_id' => $request->machine_id,
                'current_stock' => $request->current_stock,
                'description' => $request->description,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            DB::table('mrp_inventory_product_incoming')->insert($insertIncoming);

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
