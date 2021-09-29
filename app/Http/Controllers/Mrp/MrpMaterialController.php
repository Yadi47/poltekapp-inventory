<?php

namespace App\Http\Controllers\Mrp;
use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpMaterial;
use App\Models\Mrp\MrpSupplier;
use App\Models\Mrp\MrpUnit;
use App\Models\Mrp\MrpInventoryMaterial;
use App\Models\Mrp\MrpBomMaterial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class MrpMaterialController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:material-list', ['only' => ['index']]);
        $this->middleware('permission:material-create', ['only' => ['create']]);
        $this->middleware('permission:material-edit', ['only' => ['edit']]);
        $this->middleware('permission:material-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Material List';
        $data['materials'] = MrpMaterial::orderBy('id','desc')->get();
        return view('mrp.materials.material-list',$data);
    }

    public function report()
    {
        $data['page_title'] = 'Report Material List';
        $data['reports'] = MrpMaterial::get();
        return view('mrp.materials.material-report',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Material Create';
        $data['suppliers'] = MrpSupplier::get();
        $data['units'] = MrpUnit::get();
        return view('mrp.materials.material-create',$data);
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
            'material_code' => 'required|max:255',
            'material_name' => 'required|max:255',
            'part_number' => 'required|max:255',
            'dim_long' => 'required',
            'dim_width' => 'required',
            'dim_height' => 'required',
            'dim_weight' => 'required',
            // 'colour' => 'required',
            // 'price' => 'required',
            'supplier_id' => 'nullable',
            'unit_id' => 'nullable',
            'description' => 'nullable',
        ]);
        try {
            MrpMaterial::create([
                'material_code' => $request->material_code,
                'material_name' => $request->material_name,
                'part_number' => $request->part_number,
                'dim_long' => $request->dim_long,
                'dim_width' => $request->dim_width,
                'dim_height' => $request->dim_height,
                'dim_weight' => $request->dim_weight . 'gram',
                // 'colour' => $request->colour,
                // 'price' => $request->price,
                'supplier_id' => $request->supplier_id,
                'unit_id' => $request->unit_id,
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.material-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.material-list');
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
        $data['page_title'] = 'Material Edit';
        $data['suppliers'] = MrpSupplier::get();
        $data['units'] = MrpUnit::get();
        $data['material'] = MrpMaterial::find($id);
        return view('mrp.materials.material-edit',$data);
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
            'material_code' => "required|max:255",
            'material_name' => "required|max:255",
            'part_number' => 'required|max:255',
            'dim_long' => 'max:255',
            'dim_width' => 'max:255',
            'dim_height' => 'max:255',
            'dim_weight' => 'required',
            // 'colour' => 'required',
            // 'price' => 'required',
            'supplier_id' => 'nullable',
            'unit_id' => 'nullable',
            'description' => 'nullable',
        ]);
        try {
            MrpMaterial::where('id',$id)->update([
                'material_code' => $request->material_code,
                'material_name' => $request->material_name,
                'part_number' => $request->part_number,
                'dim_long' => $request->dim_long,
                'dim_width' => $request->dim_width,
                'dim_height' => $request->dim_height,
                'dim_weight' => $request->dim_weight  . 'gram',
                // 'colour' => $request->colour,
                // 'price' => $request->price,
                'supplier_id' => $request->supplier_id,
                'unit_id' => $request->unit_id,
                'description' => $request->description,
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.material-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.material-list');
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
            MrpInventoryMaterial::where('material_id', $request->id)->update(['material_id' => null]);
            MrpBomMaterial::where('material_id', $request->id)->update(['material_id' => null]);
            MrpMaterial::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }
}
