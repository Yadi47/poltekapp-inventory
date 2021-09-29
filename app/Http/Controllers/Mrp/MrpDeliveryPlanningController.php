<?php

namespace App\Http\Controllers\Mrp;

use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpInventoryProductIncoming;
use App\Models\Mrp\MrpInventoryPlanning;
use App\Models\Mrp\MrpUnit;
use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpCustomer;
use App\Models\Mrp\MrpDeliveryPlanning;
use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpInventoryProductList;
use Illuminate\Http\Request;
use DB;

class MrpDeliveryPlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:delivery_planning-list', ['only' => ['index']]);
        $this->middleware('permission:delivery_planning-create', ['only' => ['create']]);
        $this->middleware('permission:delivery_planning-edit', ['only' => ['edit']]);
        $this->middleware('permission:delivery_planning-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Delivery Planning List';
        $data['plannings'] = MrpDeliveryPlanning::orderBy('id', 'desc')->get();
        return view('mrp.delivery.delivery_planning.delivery_planning-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Delivery Planning Form';
        $data['units'] = MrpUnit::get();
        $data['customers'] = MrpCustomer::get();
        $data['inventory_products'] = MrpInventoryProductList::orderBy('id', 'asc')->get();
        $data['delivery_plannings'] = MrpDeliveryPlanning::orderBy('id', 'desc')->get();
        return view('mrp.delivery.delivery_planning.delivery_planning-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->inventory_product_list_id);
        $max = MrpInventoryProductList::where('id', $request->inventory_product_list_id)->get();
        $stock = 0;
        foreach ($max as $key => $value) {
            $stock = $value->stockActual();
        }
        // dd($request->inventory_product_list_id,);

        $validated = $request->validate([
            'do_code' => 'required|unique:mrp_delivery_plannings',
            'do_date' => 'required',
            'delivery_date' => 'required',
            'customer_id' => 'required',
            'inventory_product_list_id' => 'required',
            'quantity' => "required|max:$stock",
            'unit_id' => 'required',
            'po_code' => 'required',
        ], 
    [
        'do_code.required' => '*DO Code Wajib Diisi!',
        'do_date.required' => '*DO Date Wajib Diisi!',
        'delivery_date.required' => '*Delivery Date Wajib Diisi!',
        'customer_id.required' => '*Customer Wajib Diisi!',
        'inventory_product_list_id.required' => '*Product Wajib Diisi!',
        'quantity.required' => '*Quantity Wajib Diisi!',
        'unit_id.required' => '*Unit Wajib Diisi!',
        'po_code.required' => '*PO Wajib Diisi!',
    ]);
        try {
            DB::beginTransaction();
            $deliveryPlanning = MrpDeliveryPlanning::create([
                'do_code' => $request->do_code,
                'do_date' => date('Y-m-d', strtotime($request->do_date)),
                'delivery_date' => date('Y-m-d', strtotime($request->delivery_date)),
                'description' => $request->description,
                'customer_id' => $request->customer_id,
            ]);

            MrpInventoryPlanning::create([
                'inventory_product_list_id' => $request->inventory_product_list_id,
                'quantity' => $request->quantity,
                'delivery_planning_id' => $deliveryPlanning->id,
                'po_code' => $request->po_code,
                'unit_id' => $request->unit_id,
            ]);

            DB::commit();
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('mrp.delivery.delivery_planning.delivery_planning-edit', $deliveryPlanning->id);
        } catch (\Throwable $th) {
            DB::rollback();
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.delivery.delivery_planning.delivery_planning-list');
        }
        // Session::flash('entry-message', 'Data Successfuly created !');
        // Session::flash('alert-class', 'alert-success');
        // return redirect()->route('mrp.delivery.delivery_planning.delivery_planning-edit', $deliveryPlanning->id);
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
        $data['page_title'] = 'Delivery Planning Form';
        $data['units'] = MrpUnit::get();
        $data['inventory_products'] = MrpInventoryProductList::orderBy('id', 'asc')->get();
        $data['customers'] = MrpCustomer::get();
        $data['planning'] = MrpDeliveryPlanning::find($id);
        $data['inventory_plannings'] = MrpInventoryPlanning::where('delivery_planning_id', $id)->get();
        return view('mrp.delivery.delivery_planning.delivery_planning-edit', $data);
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
                return redirect()->route('mrp.delivery.delivery_planning.delivery_planning-edit', $id);
            }
            $request->validate([
                'do_code' => "required|unique:mrp_delivery_plannings,do_code,$id|max:255",
                'do_date' => 'required',
                'delivery_date' => 'required',
                'customer_id' => 'required',
                'inventory_product_list_id' => 'required',
                'quantity' => "required",
                'unit_id' => 'required',
                'po_code' => "unique:mrp_inventory_plannings,po_code,$id",
            ],
        [
            'do_code.required' => '*DO Code Wajib Diisi!',
            'do_date.required' => '*DO Date Wajib Diisi!',
            'delivery_date.required' => '*Delivery Date Wajib Diisi!',
            'customer_id.required' => '*Customer Wajib Diisi!',
            'inventory_product_list_id.required' => '*Product Wajib Diisi!',
            'quantity.required' => '*Quantity Wajib Diisi!',
            'unit_id.required' => '*Unit Wajib Diisi!',
            'po_code.required' => '*PO Wajib Diisi!',
        ]);
        } else {
            $request->validate([
                'do_code' => "required|unique:mrp_delivery_plannings,do_code,$id|max:255",
                'do_date' => 'required',
                'delivery_date' => 'required',
                'customer_id' => 'required',
                'po_code' => "unique:mrp_inventory_plannings,po_code,$id",
            ],[
                'do_code.required' => '*DO Code Wajib Diisi!',
                'do_date.required' => '*DO Date Wajib Diisi!',
                'delivery_date.required' => '*Delivery Date Wajib Diisi!',
                'customer_id.required' => '*Customer Wajib Diisi!',
                'po_code.required' => '*PO Wajib Diisi!',
            ]);
        }

        try {
            MrpDeliveryPlanning::where('id', $id)->update([
                'do_code' => $request->do_code,
                'do_date' => $request->do_date,
                'delivery_date' => $request->delivery_date,
                'description' => $request->description,
                'customer_id' => $request->customer_id,
            ]);

            if (isset($request->inventory_product_list_id)) {
                MrpInventoryPlanning::create([
                    'inventory_product_list_id' => $request->inventory_product_list_id,
                    'quantity' => $request->quantity,
                    'delivery_planning_id' => $id,
                    'po_code' => $request->po_code,
                    'unit_id' => $request->unit_id,
                ]);
            }
            Session::flash('message', 'Data Successfuly adited !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('mrp.delivery.delivery_planning.delivery_planning-edit', $id);
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.delivery.delivery_planning.delivery_planning-edit', $id);
        }
        // }
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
            MrpInventoryPlanning::where('delivery_planning_id', $request->id)->delete();
            MrpDeliveryPlanning::destroy($request->id);
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success');
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger');
            //throw $th;
        }
    }
}
