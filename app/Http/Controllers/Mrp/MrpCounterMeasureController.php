<?php

namespace App\Http\Controllers\Mrp;

use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpCounterMeasure;
use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpProblem;
use Illuminate\Http\Request;

class MrpCounterMeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:counter_measure-list', ['only' => ['index']]);
        $this->middleware('permission:counter_measure-create', ['only' => ['create']]);
        $this->middleware('permission:counter_measure-edit', ['only' => ['edit']]);
        $this->middleware('permission:counter_measure-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Counter Measure List';
        $data['counter_measures'] = MrpCounterMeasure::orderBy('id','desc')->get();
        return view('mrp.counter_measures.counter_measure-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Counter Measure Create';
        $data['problems'] = MrpProblem::get();
        return view('mrp.counter_measures.counter_measure-create',$data);
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
            'cm_code' => 'required|max:255',
            'cm_name' => 'required|max:255',
            'problem_id' => 'required',
            'description' => 'nullable'
        ],
    [
        'problem_id.required' => '*Problem Wajib Diisi!'
    ]);
        try {
            MrpCounterMeasure::create([
                'cm_code' => $request->cm_code,
                'cm_name' => $request->cm_name,
                'problem_id' => $request->problem_id,
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.counter_measure-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.counter_measure-list');
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
        $data['page_title'] = 'Counter Measure Edit';
        $data['counter_measure'] = MrpCounterMeasure::find($id);
        $data['problems'] = MrpProblem::get();
        return view('mrp.counter_measures.counter_measure-edit',$data);
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
            'cm_code' => "required|max:255",
            'cm_name' => "required|max:255",
            'problem_id' => "required",
            'description' => "nullable"
        ]);
        try {
            MrpCounterMeasure::where('id',$id)->update([
                'cm_code' => $request->cm_code,
                'cm_name' => $request->cm_name,
                'problem_id' => $request->problem_id,
                'description' => $request->description

                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.counter_measure-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.counter_measure-list');
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
            MrpCounterMeasure::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }
}
