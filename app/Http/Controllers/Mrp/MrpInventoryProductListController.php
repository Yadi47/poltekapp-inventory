<?php

namespace App\Http\Controllers\Mrp;
use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpInventoryProductList;
use App\Models\Mrp\MrpProduction;
use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpProductionProcess;
use Illuminate\Http\Request;

class MrpInventoryProductListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //     $this->middleware('permission:inventory_product_index-list', ['only' => ['index']]);
    //     $this->middleware('permission:inventory_product_index-create', ['only' => ['create']]);
    //     $this->middleware('permission:inventory_product_index-edit', ['only' => ['edit']]);
    //     $this->middleware('permission:inventory_product_index-delete', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $data['page_title'] = 'Inventory Product List';
        $data['inven_products'] = MrpInventoryProductList::orderBy('id','desc')->get();
        // $data = MrpInventoryProductList::all();
        // $date = MrpProduction::all();
        // dd($date->mrpInventoryProductList);
        return view('mrp.inventories.products.list-product.product-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Inventory Product Create';
        $data['products'] = MrpProduct::get();
        // dd($product->qty_good);
        // $data['products'] = MrpProduct::get();
        return view('mrp.inventories.products.list-product.product-create', $data);
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
            'product_id' => 'required',
            'stock' => 'nullable',
            'status' => 'required',
            'initial_stock' => 'nullable',
            'description' => 'nullable'
        ],
    [
        'product_id.required' => '*Part Name Wajib Diisi!',
        'status.required' => '*Status Wajib Diisi!',
    ]);
        try {
            MrpInventoryProductList::create([
                'product_id' => $request->product_id,
                'stock' => $request->initial_stock,
                'qty_target' => $request->qty_target,
                'target_day' => $request->target_day,
                'target_min' => $request->target_min,
                'target_max' => $request->target_max,
                'total_target_day' => $request->total_target_day,
                'status' => $request->status,
                'initial_stock' => $request->initial_stock,
                'description' => $request->description,
            ]);

            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.inventory_product-list');
        } catch (\Throwable $th) {
           
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.inventory_product-list');
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
        $data['page_title'] = 'Inventory Product Edit';
        $data['products'] = MrpProduct::get();
        $data['inven_product'] = MrpInventoryProductList::find($id);
        // $date = MrpInventoryProductList::find($id);
        return view('mrp.inventories.products.list-product.product-edit', $data);
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
            'product_id' => "required",
            'stock' => "nullable",
            'status' => "required|in:OK,Not OK",
            'initial_stock' => "nullable",
            'description' => "nullable"
        ],
    [
        [
            'product_id.required' => '*Part Name Wajib Diisi!',
            'status.required' => '*Status Wajib Diisi!',
        ]
    ]);
        try {
            
            MrpInventoryProductList::where('id',$id)->update([
                'product_id' => $request->product_id,
                'stock' => $request->initial_stock,
                'qty_target' => $request->qty_target,
                'target_day' => $request->target_day,
                'target_min' => $request->target_min,
                'target_max' => $request->target_max,
                'total_target_day' => $request->total_target_day,
                'status' => $request->status,
                'initial_stock' => $request->initial_stock,
                'description' => $request->description,

                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.inventory_product-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.inventory_product-list');
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
            MrpInventoryProductList::destroy($request->id);
            MrpProduction::where('product_id', $request->id)->update(['product_id' => null]);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }
}
