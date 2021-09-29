<?php

namespace App\Http\Controllers\Mrp;
use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpProblem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrpProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:problem-list', ['only' => ['index']]);
        $this->middleware('permission:problem-create', ['only' => ['create']]);
        $this->middleware('permission:problem-edit', ['only' => ['edit']]);
        $this->middleware('permission:problem-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Problem List';
        $data['problems'] = MrpProblem::orderBy('id','desc')->get();
        return view('mrp.problems.problem-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Problem Create';
        return view('mrp.problems.problem-create',$data);
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
            'problem_code' => 'required|max:255',
            'problem_name' => 'required|max:255',
            'description' => 'nullable'
        ]);
        try {
            MrpProblem::create([
                'problem_code' => $request->problem_code,
                'problem_name' => $request->problem_name,
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.problem-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.problem-list');
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
        $data['page_title'] = 'Problem Edit';
        $data['problem'] = MrpProblem::find($id);
        return view('mrp.problems.problem-edit',$data);
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
            'problem_code' => "required|max:255",
            'problem_name' => "required|max:255",
            'description' => "nullable"
        ]);
        try {
            MrpProblem::where('id',$id)->update([
                'problem_code' => $request->problem_code,
                'problem_name' => $request->problem_name,
                'description' => $request->description

                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.problem-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.problem-list');
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
            MrpProblem::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }
}
