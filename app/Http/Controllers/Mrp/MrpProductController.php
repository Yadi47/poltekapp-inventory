<?php

namespace App\Http\Controllers\Mrp;
use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpCustomer;
use App\Models\Mrp\MrpUnit;
use App\Models\Mrp\MrpBom;
use App\Models\Mrp\MrpPlanningProductionProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrpProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:product-list', ['only' => ['index']]);
        $this->middleware('permission:product-create', ['only' => ['create']]);
        $this->middleware('permission:product-edit', ['only' => ['edit']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Product List';
        $data['products'] = MrpProduct::orderBy('id','desc')->get();
        // dd($data['products']);
        return view('mrp.products.product-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Product Create';
        $data['units'] = MrpUnit::get();
        $data['customers'] = MrpCustomer::get();
        $data['boms'] = MrpBom::get();
        return view('mrp.products.product-create',$data);
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
            'product_code' => 'required|max:255',
            'part_name' => 'required|max:255',
            'dim_long' => 'required',
            'dim_width' => 'required',
            'dim_height' => 'required',
            'dim_weight' => 'required',
            'bom_id' => 'nullable',
            // 'price' => 'required',
            'unit_id' => 'required',
            'customer_id' => 'nullable',
            'description' => 'nullable',
            'part_number' => 'required',
            // 'speed_product' => 'required',
        ]);
        // dd($request->all());
        try {
            MrpProduct::create([
                'product_code' => $request->product_code,
                'product_name' => $request->product_name,
                'part_name' => $request->part_name,
                'dim_long' => $request->dim_long,
                'dim_width' => $request->dim_width,
                'dim_height' => $request->dim_height,
                'dim_weight' => $request->dim_weight  . 'gram',
                // 'colour' => $request->colour,
                // 'price' => $request->price,
                'unit_id' => $request->unit_id,
                'customer_id' => $request->customer_id,
                'description' => $request->description,
                'part_number' => $request->part_number,
                'speed_product' => $request->speed_product,
                'bom_id' => $request->bom_id,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.product-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.product-list');
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
        $data['page_title'] = 'Product Edit';
        $data['units'] = MrpUnit::get();
        $data['customers'] = MrpCustomer::get();
        $data['boms'] = MrpBom::get();
        $data['product'] = MrpProduct::find($id);
        return view('mrp.products.product-edit',$data);
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
            'product_code' => 'required|max:255',
            'part_name' => 'required|max:255',
            'dim_long' => 'max:255',
            'dim_width' => 'max:255',
            'dim_height' => 'max:255',
            'dim_weight' => 'required',
            'bom_id' => 'nullable',
            // 'price' => 'required',
            'unit_id' => 'required',
            'customer_id' => 'nullable',
            'part_number' => 'required',
            // 'speed_product' => 'required',
            'description' => "nullable"
        ]);
        try {
            MrpProduct::where('id',$id)->update([
                'product_code' => $request->product_code,
                'product_name' => $request->product_name,
                'part_name' => $request->part_name,
                'dim_long' => $request->dim_long,
                'dim_width' => $request->dim_width,
                'dim_height' => $request->dim_height,
                'dim_weight' => $request->dim_weight  . 'gram',
                // 'colour' => $request->colour,
                // 'price' => $request->price,
                'unit_id' => $request->unit_id,
                'bom_id' => $request->bom_id,
                'customer_id' => $request->customer_id,
                'part_number' => $request->part_number,
                // 'speed_product' => $request->speed_product,
                'description' => $request->description

                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.product-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.product-list');
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
            MrpPlanningProductionProduct::where('product_id', $request->id)->update(['product_id' => null]);
            MrpProduct::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }

    
}
