<?php

namespace App\Http\Controllers\Mrp;

use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpDeliveryPlanning;
use App\Models\Mrp\MrpInventoryPlanning;
use App\Models\Mrp\MrpInventoryShipment;
use App\Models\Mrp\MrpVehicle;
use App\Models\Mrp\MrpUnit;
use App\Models\Mrp\MrpProduction;
use App\Models\Mrp\MrpCustomer;
use App\Models\Mrp\MrpDeliveryShipment;
use App\Models\Mrp\MrpInventoryProductList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
// use Illuminate\Support\Facades\DB;

class MrpDeliveryShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:delivery_shipment-list', ['only' => ['index']]);
        $this->middleware('permission:delivery_shipment-create', ['only' => ['create']]);
        $this->middleware('permission:delivery_shipment-edit', ['only' => ['edit']]);
        $this->middleware('permission:delivery_shipment-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Delivery Shipment List';
        $data['shipments'] = MrpDeliveryShipment::orderBy('id', 'desc')->get();
        return view('mrp.delivery.delivery_shipment.delivery_shipment-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Delivery Shipment Form';
        $data['vehicles'] = MrpVehicle::get();
        $data['customers'] = MrpCustomer::get();
        $data['plannings'] = MrpDeliveryPlanning::get();
        $data['units'] = MrpUnit::get();
        $data['inventory_products'] = MrpInventoryProductList::orderBy('id', 'asc')->get();
        // $data['productions'] = MrpProduction::get();
        return view('mrp.delivery.delivery_shipment.delivery_shipment-create', $data);
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
            'dn_code' => 'required|unique:mrp_delivery_shipments',
            'delivery_date' => 'required',
            'vehicle_id' => 'required',
            'cust_id' => 'nullable',
            'planning_id' => 'required',
            'description' => 'nullable|min:3'
        ],
    [
        'dn_code.required' => '*DN Code Wajib Diisi!',
        'delivery_date.required' => '*Delivery Date Code Wajib Diisi!',
        'vehicle_id.required' => '*Vehicle Wajib Diisi!',
        'planning_id.required' => '*Planning Wajib Diisi!',
    ]);

        // dd($request->all());
        DB::beginTransaction();
        try {
            $deliveryShipment = MrpDeliveryShipment::create([
                'dn_code' => $request->dn_code,
                'delivery_date' => date('Y-m-d', strtotime($request->delivery_date)),
                'vehicle_id' => $request->vehicle_id,
                'customer_id' => $request->cust_id,
                'description' => $request->description,
                'delivery_planning_id' => $request->planning_id,
            ]);
            $inventoryPlanning = MrpInventoryPlanning::where('delivery_planning_id', $request->planning_id)->get();
            foreach ($inventoryPlanning as $key => $value) {
                # code...
                MrpInventoryShipment::create([
                    'delivery_shipment_id' => $deliveryShipment->id,
                    'inventory_product_list_id' => $value->inventory_product_list_id,
                    'quantity' => $value->quantity,
                    'po_code' => $value->po_code,
                    'unit_id' => $value->unit_id,
                ]);
            }
            DB::commit();
            Session::flash('entry-message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('mrp.delivery.delivery_shipment.delivery_shipment-edit', $deliveryShipment->id);
        } catch (\Throwable $th) {
            DB::rollback();
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.delivery.delivery_shipment.delivery_shipment-list');
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
        $data['page_title'] = 'Delivery Shipment Form';
        $data['vehicles'] = MrpVehicle::get();
        $data['units'] = MrpUnit::get();
        $data['inventory_products'] = MrpInventoryProductList::orderBy('id', 'asc')->get();
        $data['customers'] = MrpCustomer::get();
        $data['plannings'] = MrpDeliveryPlanning::get();
        $data['shipment'] = MrpDeliveryShipment::find($id);
        $data['inventory_shipments'] = MrpInventoryShipment::where('delivery_shipment_id', $id)->get();;
        return view('mrp.delivery.delivery_shipment.delivery_shipment-edit', $data);
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
        if (isset($request->inventory_product_list_id)) {
            $max = MrpInventoryProductList::where('id', $request->inventory_product_list_id)->get();
            $stock = 0;
            foreach ($max as $key => $value) {
                # code...
                $stock = $value->stockActual();
            }
            if ($request->quantity > $stock) {
                Session::flash('message', 'Quantity is greater than the number of products in inventory !');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('mrp.delivery.delivery_shipment.delivery_shipment-edit', $id);
            }
        }
        $trigger = MrpDeliveryShipment::where('id', $id)->select('description')->first();
        if ($request->description !== $trigger->description) {
            try {
                MrpDeliveryShipment::where('id', $id)->update([
                    'description' => $request->description
                ]);
                Session::flash('entry-message', 'Data Successfuly edited !');
                Session::flash('alert-class', 'alert-success');
                return redirect()->route('mrp.delivery.delivery_shipment.delivery_shipment-edit', $id);
            } catch (\Throwable $th) {
                Session::flash('entry-message', $th->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('mrp.delivery.delivery_shipment.delivery_shipment-edit', $id);
            }
        } else {

            $validated = $request->validate([
                'inventory_product_list_id' => 'required',
                'quantity' => "required",
                'unit_id' => 'required',
                'po_code' => "unique:mrp_inventory_shipments,po_code,$id",
            ],
        [
            'inventory_product_list_id.required' => 'Product Wajib Diisi!',
            'quantity.required' => 'Quantity Wajib Diisi!',
            'unit_id.required' => 'Unit Wajib Diisi!',
        ]);

            try {
                MrpInventoryShipment::create([
                    'delivery_shipment_id' => $id,
                    'inventory_product_list_id' => $request->inventory_product_list_id,
                    'quantity' => $request->quantity,
                    'po_code' => $request->po_code,
                    'unit_id' => $request->unit_id,
                ]);

                // proses pengurangan stock di inventory product list
                $inventoryProductList = MrpInventoryProductList::findOrFail($request->inventory_product_list_id);
                $inventoryProductList->stock = $inventoryProductList->stock - $request->quantity;
                $inventoryProductList->save();

                Session::flash('message', 'Data Successfuly added !');
                Session::flash('alert-class', 'alert-success');
                return redirect()->route('mrp.delivery.delivery_shipment.delivery_shipment-edit', $id);
            } catch (\Throwable $th) {
                Session::flash('message', $th->getMessage());
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('mrp.delivery.delivery_shipment.delivery_shipment-edit', $id);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inventoryShipmentdestroy(Request $request)
    {
        try {
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success');
            $inventoryShipment = MrpInventoryShipment::findOrFail($request->id);
            
            $inventoryProductList = MrpInventoryProductList::findOrFail($inventoryShipment->inventory_product_list_id);
            $inventoryProductList->stock = $inventoryProductList->stock + $inventoryShipment->quantity;
            $inventoryProductList->save();
            $inventoryShipment->delete();

            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            //throw $th;
        }
    }

    public function destroy(Request $request)
    {
        try {
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success');
            MrpInventoryShipment::where('delivery_shipment_id', $request->id)->delete();
            MrpDeliveryShipment::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger');
            //throw $th;
        }
    }
}
