<?php

namespace App\Http\Controllers\Mrp;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mrp\MrpDeliveryShipment;
use App\Models\Mrp\MrpEmployee;
use App\Models\Mrp\MrpInventoryProductOut;
use App\Models\Mrp\MrpInventoryProductIncoming;
use App\Models\Mrp\MrpInventoryShipment;
use App\Models\Mrp\MrpInventoryProductList;
use File;
use Illuminate\Support\Facades\DB;

class MrpInventoryProductOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:inventory_product_stock_out-index', ['only' => ['index']]);
        $this->middleware('permission:inventory_product_stock_out-create', ['only' => ['create']]);
        $this->middleware('permission:inventory_product_stock_out-edit', ['only' => ['edit']]);
        $this->middleware('permission:inventory_product_stock_out-delete', ['only' => ['destroy']]);
    }

    public function index()
    {

        
        $data['page_title'] = 'Product Stock Out';
        // $data['inventory_products'] = MrpInventoryProductList::orderBy('id', 'asc')->get();
        $data['delivery_shipments'] = MrpDeliveryShipment::orderBy('id', 'desc')->get();
        $data['inventory_products'] = MrpInventoryProductOut::orderBy('id', 'desc')->get();
        return view('mrp.inventories.products.stock-out.product-out-list', $data);
        // dd($data['plannings']);
    }

    public function indexSortir()
    {
        $data['page_title'] = 'Product Stock Out Sortir';
        $data['inventory_product_incomings'] = MrpInventoryProductIncoming::orderBy('id', 'asc')->get();
        return view('mrp.inventories.products.stock-out.product-out-sortir', $data);
        // dd($data['plannings']);
    }

    public function create()
    {
        $data['page_title'] = 'Product Stock Out Create';
        $data['employees'] = MrpEmployee::get();
        $data['delivery_shipments'] = MrpDeliveryShipment::get();
        $data['inventory_products'] = MrpInventoryProductList::get();

        return view('mrp.inventories.products.stock-out.product-out-create', $data);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_outgoing' => 'required',
            'employee_id' => 'required',
            // 'delivery_shipment_id' => 'nullable',
            'inventory_product_list_id' => 'required',
            'current_stock' => 'nullable',
            'description' => 'nullable'
        ],
    [
        'inventory_product_list_id.required' => '*Part Name Wajib Diisi!',
        'product_outgoing.required' => '*Qty Out Wajib Diisi!',
        'employee_id.required' => '*PIC Wajib Diisi!',
    ]);
        // dd($request->all());
        try {
            MrpInventoryProductList::where('id', $request->inventory_product_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpInventoryProductOut::create([
                // 'delivery_shipment_id' => $request->delivery_shipment_id,
                'product_outgoing' => $request->product_outgoing,
                'employee_id' => $request->employee_id,
                'current_stock' => $request->current_stock,
                'inventory_product_list_id' => $request->inventory_product_list_id,
                'description' => $request->description
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.product-out-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.product-out-list');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
        public function show($id)
    {
        $product_out = MrpInventoryShipment::where('id', $id)->get();
        // dd($product_out->inventoryProductList); 
        $data['detail_product'] = $product_out->map(function ($p) {
            $v['part_name'] = $p->inventoryProductList->product->part_name;
            $v['part_number'] = $p->inventoryProductList->product->part_number;
            $v['quantity'] = $p->quantity;
            $v['unit'] = $p->inventoryProductList->product->unit->unit_name;
            return (object) $v;
        });
        
        // dd($data['detail_product']);
        return view('mrp.inventories.products.stock-out.product-out-show', $data);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Inventory Material Conveyor Production Edit';
        $data['delivery_shipments'] = MrpDeliveryShipment::get();
        $data['employees'] = MrpEmployee::get();
        $data['inventory_products'] = MrpInventoryProductList::get();
        $data['product_out'] = MrpInventoryProductOut::find($id);
        return view('mrp.inventories.products.stock-out.product-out-edit', $data);
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
            'product_outgoing' => 'required',
            'employee_id' => 'required',
            // 'delivery_shipment_id' => 'nullable',
            'inventory_product_list_id' => 'required',
            'description' => 'nullable'
            
        ],
    [
        'inventory_product_list_id.required' => '*Part Name Wajib Diisi!',
        'product_outgoing.required' => '*Qty Out Wajib Diisi!',
        'employee_id.required' => '*PIC Wajib Diisi!',
    ]);

        try {
            MrpInventoryProductList::where('id', $request->inventory_product_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpInventoryProductOut::where('id',$id)->update([
                // 'delivery_shipment_id' => $request->delivery_shipment_id,
                'product_outgoing' => $request->product_outgoing,
                'employee_id' => $request->employee_id,
                'current_stock' => $request->current_stock,
                'inventory_product_list_id' => $request->inventory_product_list_id,
                'description' => $request->description

                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.product-out-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.product-out-list');
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
            $inventoryProductOut =   MrpInventoryProductOut::findOrFail($request->id);

            $inventoryProductList = MrpInventoryProductList::findOrFail($inventoryProductOut->inventory_product_list_id);
            $inventoryProductList->stock = $inventoryProductList->stock + $inventoryProductOut->product_outgoing;
            $inventoryProductList->save();
            $inventoryProductOut->delete();
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }
    public function getInventoryProductListById($id)
    {
        $inventory_product = MrpInventoryProductList::find($id);
        return $inventory_product;
    }

    public function createOut()
    {
        $data['employees'] = MrpEmployee::get();
        $data['delivery_shipments'] = MrpDeliveryShipment::get();
        $data['inventory_products'] = MrpInventoryProductList::get();
        return view('mrp.inventories.products.stock-out.product-out-create-api', $data);
    }

    public function storeOut(Request $request)
    {
        try {
            MrpInventoryProductList::where('id', $request->product_list_id)->update([
                'stock' => $request->current_stock
            ]);
            $insertOutgoing = [
                'delivery_shipment_id' => $request->delivery_shipment_id,
                'product_outgoing' => $request->product_outgoing,
                'employee_id' => $request->employee_id,
                'current_stock' => $request->current_stock,
                'inventory_product_list_id' => $request->product_list_id,
                'description' => $request->description,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            DB::table('mrp_inventory_product_out')->insert($insertOutgoing);

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
