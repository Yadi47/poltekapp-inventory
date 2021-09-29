<?php

namespace App\Http\Controllers\Mrp;
use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpSupplier;
use App\Models\Mrp\MrpMaterial;
use App\Models\Mrp\MrpMachine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrpSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:supplier-list', ['only' => ['index']]);
        $this->middleware('permission:supplier-create', ['only' => ['create']]);
        $this->middleware('permission:supplier-edit', ['only' => ['edit']]);
        $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Supplier List';
        $data['suppliers'] = MrpSupplier::orderBy('id','desc')->get();
        return view('mrp.suppliers.supplier-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Supplier Create';
        return view('mrp.suppliers.supplier-create',$data);
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
            'supplier_code' => 'required|max:255',
            'supplier_name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'nullable|min:11|numeric',
            'email' => 'nullable',
            'website' => 'nullable',
            'description' => 'nullable'
        ]);
        try {
            MrpSupplier::create([
                'supplier_code' => $request->supplier_code,
                'supplier_name' => $request->supplier_name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'website' => $request->website,
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.supplier-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.supplier-list');
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
        $data['page_title'] = 'Supplier Edit';
        $data['supplier'] = MrpSupplier::find($id);
        return view('mrp.suppliers.supplier-edit',$data);
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
            'supplier_code' => "required|max:255",
            'supplier_name' => "required|max:255",
            'address' => 'required|max:255',
            'phone' => 'nullable',
            'email' => 'nullable',
            'website' => 'nullable',
            'description' => "nullable"
        ]);
        try {
            MrpSupplier::where('id',$id)->update([
                'supplier_code' => $request->supplier_code,
                'supplier_name' => $request->supplier_name,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'website' => $request->website,
                'description' => $request->description

                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.supplier-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.supplier-list');
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
            MrpMaterial::where('supplier_id', $request->id)->update(['supplier_id' => null]);
            MrpMachine::where('supplier_id', $request->id)->update(['supplier_id' => null]);
            MrpSupplier::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }
}
