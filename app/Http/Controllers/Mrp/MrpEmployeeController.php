<?php

namespace App\Http\Controllers\Mrp;

use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpEmployee;
use App\Models\Mrp\MrpPlace;
use App\Models\Mrp\MrpShift;
use App\Models\Mrp\MrpInventoryMaterialList;
use App\Models\Mrp\MrpInventoryMaterialIncoming;
use App\Models\Mrp\MrpInventoryMaterialOut;
use App\Models\Mrp\MrpMaterialSortir;
use App\Models\Mrp\MrpInventoryProductList;
use App\Models\Mrp\MrpInventoryProductIncoming;
use App\Models\Mrp\MrpInventoryProductOut;
use App\Models\Mrp\MrpProductSortir;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrpEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:employee-list', ['only' => ['index']]);
        $this->middleware('permission:employee-create', ['only' => ['create']]);
        $this->middleware('permission:employee-edit', ['only' => ['edit']]);
        $this->middleware('permission:employee-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Employee List';
        $data['employees'] = MrpEmployee::orderBy('id','desc')->get();
        return view('mrp.employees.employee-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Employee Create';
        $data['places'] = MrpPlace::get();
        $data['shifts'] = MrpShift::get();
        return view('mrp.employees.employee-create',$data);
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
            'nik' => 'required|max:255',
            'employee_name' => 'required|max:255',
            'departement' => 'required|max:255',
            'section' => 'required|max:255',
            'title' => 'required|max:255',
            'grade' => 'required|max:255',
            'place_id' => 'nullable',
            'shift_id' => 'required',
            'description' => 'nullable'
        ]);

        try {
            MrpEmployee::create([
                'nik' => $request->nik,
                'employee_name' => $request->employee_name,
                'departement' => $request->departement,
                'section' => $request->section,
                'title' => $request->title,
                'grade' => $request->grade,
                // 'place_id' => $request->place_id,
                'shift_id' => $request->shift_id,
                'description' => $request->description,
            ])->places()->attach($request->get('place_id'));

            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.employee-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.employee-list');
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
        $data['page_title'] = 'Employee Edit';
        $data['places'] = MrpPlace::get();
        $data['shifts'] = MrpShift::get();
        $data['employee'] = MrpEmployee::find($id);
        return view('mrp.employees.employee-edit',$data);
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
            
            'nik' => "required|max:255",
            'employee_name' => 'required|max:255',
            'departement' => 'required|max:255',
            'section' => 'required|max:255',
            'title' => 'required|max:255',
            'grade' => 'required|max:255',
            'place_id' => 'nullable',
            'shift_id' => 'required',
            'description' => 'nullable'
        ]);

        try {
            $places = MrpEmployee::findOrFail($id);
          
            $places->update([
                'nik' => $request->nik,
                'employee_name' => $request->employee_name,
                'departement' => $request->departement,
                'section' => $request->section,
                'title' => $request->title,
                'grade' => $request->grade,
                // 'place_id' => $request->place_id,
                'shift_id' => $request->shift_id,
                'description' => $request->description

                
          ]);
        $places->places()->sync($request->get('place_id'));
                
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.employee-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.employee-list');
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
            MrpEmployee::destroy($request->id);
            MrpInventoryProductList::where('customer_id', $request->id)->update(['customer_id' => null]);
            MrpInventoryProductIncoming::where('customer_id', $request->id)->update(['customer_id' => null]);
            MrpInventoryProductOut::where('customer_id', $request->id)->update(['customer_id' => null]);
            MrpProductSortir::where('customer_id', $request->id)->update(['customer_id' => null]);
            MrpInventoryMaterialList::where('customer_id', $request->id)->update(['customer_id' => null]);
            MrpInventoryMaterialIncoming::where('customer_id', $request->id)->update(['customer_id' => null]);
            MrpInventoryMaterialOut::where('customer_id', $request->id)->update(['customer_id' => null]);
            MrpMaterialSortir::where('customer_id', $request->id)->update(['customer_id' => null]);
            MrpPlace::where('place_id', $request->id)->update(['place_id' => null]);

            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }
    public function importEmployee(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new EmployeeImport, $request->file('import_file')); 
                return back()->with(['success' => 'Import Employee Success!']);
            } catch (\Throwable $th) {
                 dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        } 
    }
}
