<?php

namespace App\Http\Controllers\Mrp;
use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpCustomer;
use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpPlanningProduction;
use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpCustomerDocsCd;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;


class MrpCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:customer-list', ['only' => ['index']]);
        $this->middleware('permission:customer-create', ['only' => ['create']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Customer List';
        $data['customers'] = MrpCustomer::orderBy('id','desc')->get();
        return view('mrp.customers.customer-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Customer Create';
        return view('mrp.customers.customer-create',$data);
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
            'customer_code' => 'required|unique:mrp_customers|max:255',
            'customer_name' => 'required|max:255',
            // 'dock_cd' => 'nullable',
            'address' => 'required|max:255',
            'phone' => 'nullable|min:11|numeric',
            'email' => 'nullable',
            'website' => 'nullable',
            'description' => 'nullable'
        ]);
        try {
            DB::beginTransaction();
            
            $customer = MrpCustomer::create([
                'customer_code' => $request->customer_code,
                'customer_name' => $request->customer_name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'website' => $request->website,
                'description' => $request->description,
            ]);
            // $customerId = $customer->id;
            // dd($request->all());
            
            // $dock = [];
            // foreach ($request->dock_cd as $key => $value) {
            //     if ($request->dock_cd[$key] != "") {
            //         // $productInsert[] = ;
            //         $params = [
            //             'customer_id' => $customerId,
            //             'dock_cd' => $request->dock_cd[$key],
            //         ];
            //         array_push($dock, $params);
                    
            //     }
            // }
            // MrpCustomerDocsCd::insert($dock);
            
            DB::commit();
            
            
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.customer-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.customer-list');
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
        $data['customer_dock'] = MrpCustomer::findOrFail($id);
        return view('mrp.customers.customer-show', $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Customer Edit';
        $data['customer'] = MrpCustomer::find($id);
        
        return view('mrp.customers.customer-edit',$data);
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
            'customer_code' => "required|max:255|unique:mrp_customers,customer_code,$id",
            'customer_name' => "required|max:255",
            // 'dock_cd' => 'nullable',
            'address' => 'required|max:255',
            'phone' => 'nullable',
            'email' => 'nullable',
            'website' => 'nullable',
            'description' => "nullable"
        ]);
        try {
            $customer = MrpCustomer::findOrFail($id);
            $customer->update([
                'customer_code' => $request->customer_code,
                'customer_name' => $request->customer_name,
                'dock_cd' => $request->dock_cd,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'website' => $request->website,
                'description' => $request->description

                
                ]);
            // $pid = $customer->id;

            // $dockCdInsert = [];

            // $data = MrpCustomerDocsCd::where('customer_id', $id);
            // $data->delete();

            // // --- CREATE PIVOT COMPOSISI
            // foreach ($request->dock_cd as $key => $value) {
            //     if ($request->dock_cd[$key] != "") {
            //         $params = [
            //             'customer_id' => $pid,
            //             'dock_cd' => $request->dock_cd[$key],
            //             'updated_at' => Carbon::now(),

            //         ];
            //         array_push($dockCdInsert, $params);

            //     }
            // }
            // MrpCustomerDocsCd::insert($dockCdInsert);

            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.customer-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.customer-list');
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
            MrpProduct::where('customer_id', $request->id)->update(['customer_id' => null]);
            MrpPlanningProduction::where('customer_id', $request->id)->update(['customer_id' => null]);
            MrpCustomerDocsCd::where('customer_id', $request->id)->update(['customer_id' => null]);
            MrpCustomer::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }
}
