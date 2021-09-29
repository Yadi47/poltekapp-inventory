<?php

namespace App\Http\Controllers\Mrp;
use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpEmployee;
use App\Models\Mrp\MrpInventoryProductList;
use App\Models\Mrp\MrpProductSortir;
use App\Models\Mrp\MrpProductSortirOK;
use App\Models\Mrp\MrpProductSortirNG;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrpProductSortirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Product Recheck ';
        $data['product_sortirs'] = MrpProductSortir::orderBy('id', 'desc')->get();
        return view('mrp.inventories.products.stock-out.sortir.product-sortir-list', $data);
    }

    public function indexSortirOK()
    {
        $data['page_title'] = 'Product Recheck OK';
        $data['product_sortir_ok'] = MrpProductSortirOK::orderBy('id', 'desc')->get();
        return view('mrp.inventories.products.stock-out.sortir.product-sortir-ok-list', $data);
    }
    public function indexSortirNG()
    {
        $data['page_title'] = 'Product Recheck NG';
        $data['product_sortir_ng'] = MrpProductSortirNG::orderBy('id', 'desc')->get();
        return view('mrp.inventories.products.stock-out.sortir.product-sortir-ng-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    public function dashboardTotalProduct()
    {
        $data['page_title'] = 'Product Recheck OK Create';
        $data['product_sortirs'] = MrpProductSortir::orderBy('id', 'asc')->get();
        return view('mrp.dashboard.product.total-product.total-product-list', $data);
    }

    public function dashboardTotalInProduct()
    {
        $data['page_title'] = 'Product Recheck OK List';
        $data['product_sortirs'] = MrpProductSortirOk::orderBy('id', 'desc')->get();
        // dd($data['material_sortirs']);
        return view('mrp.dashboard.product.sortir-ok-product.sortir-ok-product-list', $data);
    }

    public function dashboardTotalNgProduct()
    {
        $data['page_title'] = 'Product Recheck NG List';
        $data['product_sortirs'] = MrpProductSortirNg::orderBy('id', 'desc')->get();
        // dd($data['material_sortirs']);
        return view('mrp.dashboard.product.sortir-ng-product.sortir-ng-product-list', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Product Recheck Create';
        $data['inven_products'] = MrpInventoryProductList::get();
        $data['employees'] = MrpEmployee::get();
        return view('mrp.inventories.products.stock-out.sortir.product-sortir-create', $data);
    }

    public function createSortirOK()
    {
        $data['page_title'] = 'Product Recheck OK Create';
        $data['inven_products'] = MrpInventoryProductList::get();
        $data['employees'] = MrpEmployee::get();
        return view('mrp.inventories.products.stock-out.sortir.product-sortir-ok-create', $data);
    }

    

    public function createSortirNG()
    {
        $data['page_title'] = 'Product Recheck NG Create';
        $data['inven_products'] = MrpInventoryProductList::get();
        $data['employees'] = MrpEmployee::get();
        return view('mrp.inventories.products.stock-out.sortir.product-sortir-ng-create', $data);
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
            'qty_sortir' => 'nullable',
            'employee_id' => 'required',
            'description' => 'nullable'
        ],
    [
        'inventory_product_list_id.required' => '*Part Name Wajib Diisi!',
        'employee_id.required' => '*PIC Wajib Diisi!',
    ]);
        try {
            MrpInventoryProductList::where('id',$request->inventory_product_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpProductSortir::create([
                'inventory_product_list_id' => $request->inventory_product_list_id,
                'qty_sortir' => $request->qty_sortir,
                'current_stock' => $request->current_stock,
                'employee_id' => $request->employee_id,
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.product-sortir-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.product-sortir-list');
        }
    }

    public function storeSortirOK(Request $request)
    {
        $validated = $request->validate([
            'inventory_product_list_id' => 'required',
            'qty_ok' => 'nullable',
            'employee_id' => 'required',
            'current_stock' => 'nullable',
            'date' => 'nullable',
            'description' => 'nullable'
        ],
        [
            'inventory_product_list_id.required' => '*Part Name Wajib Diisi!',
            'employee_id.required' => '*PIC Wajib Diisi!',

        ]);
        try {
            MrpInventoryProductList::where('id',$request->inventory_product_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpProductSortirOk::create([
                'inventory_product_list_id' => $request->inventory_product_list_id,
                'qty_ok' => $request->qty_ok,
                'current_stock' => $request->current_stock,
                'employee_id' => $request->employee_id,
                'date' => date('Y-m-d', strtotime($request->date)),
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.product-sortir-list-sortir-ok');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.product-sortir-list-sortir-ok');
        }
    }

    public function storeSortirNG(Request $request)
    {
        $validated = $request->validate([
            'inventory_product_list_id' => 'required',
            'qty_ng' => 'nullable',
            'employee_id' => 'required',
            'date' => 'nullable',
            'description' => 'nullable'
        ],
        [
            'inventory_product_list_id.required' => '*Part Name Wajib Diisi!',
            'employee_id.required' => '*PIC Wajib Diisi!',

        ]);
        try {
            MrpProductSortirNG::create([
                'inventory_product_list_id' => $request->inventory_product_list_id,
                'qty_ng' => $request->qty_ng,
                'employee_id' => $request->employee_id,
                'date' => date('Y-m-d', strtotime($request->date)),
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.product-sortir-list-sortir-ng');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.product-sortir-list-sortir-ng');
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
        $data['page_title'] = 'Product Recheck Edit';
        $data['inven_products'] = MrpInventoryProductList::get();
        $data['employees'] = MrpEmployee::get();
        $data['product_sortir'] = MrpProductSortir::findOrFail($id);
        return view('mrp.inventories.products.stock-out.sortir.product-sortir-edit', $data);

    }

    public function editSortirOK($id)   
    {
        $data['page_title'] = 'Product Recheck OK Edit';
        $data['inven_products'] = MrpInventoryProductList::get();
        $data['employees'] = MrpEmployee::get();
        $data['product_sortir_ok'] = MrpProductSortirOK::findOrFail($id);
        return view('mrp.inventories.products.stock-out.sortir.product-sortir-ok-edit', $data);

    }

    public function editSortirNG($id)   
    {
        $data['page_title'] = 'Product Recheck NG Edit';
        $data['inven_products'] = MrpInventoryProductList::get();
        $data['employees'] = MrpEmployee::get();
        $data['product_sortir_ng'] = MrpProductSortirNG::findOrFail($id);
        return view('mrp.inventories.products.stock-out.sortir.product-sortir-ng-edit', $data);

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
            'inventory_product_list_id' => 'required',
            'qty_sortir' => 'nullable',
            'employee_id' => 'required',
            'current_stock' => 'nullable',
            'description' => 'nullable'
        ],
        [
            'inventory_product_list_id.required' => '*Part Name Wajib Diisi!',
            'employee_id.required' => '*PIC Wajib Diisi!',

        ]);
        try {
            MrpInventoryProductList::where('id',$request->inventory_product_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpProductSortir::where('id',$id)->update([
                'inventory_product_list_id' => $request->inventory_product_list_id,
                'qty_sortir' => $request->qty_sortir,
                'current_stock' => $request->current_stock,
                'employee_id' => $request->employee_id,
                'description' => $request->description
                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.product-sortir-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.product-sortir-list');
        }
    }

    //sortir ok
    public function updateSortirOK(Request $request, $id)
    {
        $validated = $request->validate([
            'inventory_product_list_id' => 'required',
            'qty_ok' => 'nullable',
            'employee_id' => 'required',
            'current_stock' => 'nullable',
            'date' => 'nullable',
            'description' => 'nullable'
        ],
        [
            'inventory_product_list_id.required' => '*Part Name Wajib Diisi!',
            'employee_id.required' => '*PIC Wajib Diisi!',
        ]);
        try {
        MrpInventoryProductList::where('id',$request->inventory_product_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpProductSortirOK::where('id',$id)->update([
                
                'inventory_product_list_id' => $request->inventory_product_list_id,
                'qty_ok' => $request->qty_ok,
                'current_stock' => $request->current_stock,
                'employee_id' => $request->employee_id,
                'date' => date('Y-m-d', strtotime($request->date)),
                'description' => $request->description

                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.product-sortir-list-sortir-ok');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.product-sortir-list-sortir-ok');
        }
    }

    //sortir ng
    public function updateSortirNG(Request $request, $id)
    {
        $validated = $request->validate([
            'inventory_product_list_id' => 'required',
            'qty_ng' => 'nullable',
            'employee_id' => 'required',
            'date' => 'nullable',
            'description' => 'nullable'
        ],
        [
            'inventory_product_list_id.required' => '*Part Name Wajib Diisi!',
            'employee_id.required' => '*PIC Wajib Diisi!',
        ]);
        try {
        MrpInventoryProductList::where('id',$request->inventory_product_list_id)->update([
                'stock' => $request->current_stock
            ]);
            MrpProductSortirNG::where('id',$id)->update([
                
                'inventory_product_list_id' => $request->inventory_product_list_id,
                'qty_ng' => $request->qty_ng,
                'employee_id' => $request->employee_id,
                'date' => date('Y-m-d', strtotime($request->date)),
                'description' => $request->description

                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.product-sortir-list-sortir-ng');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.product-sortir-list-sortir-ng');
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
            MrpProductSortir::destroy($request->id);
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
            MrpProductSortirOK::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }

    public function getInventoryProductListById($id)
    {
        $inven_product = MrpInventoryProductList::find($id);
        return $inven_product;
    }
}
