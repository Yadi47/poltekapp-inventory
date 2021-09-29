<?php

namespace App\Http\Controllers\Mrp;
use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpProcess;
use App\Models\Mrp\MrpMachine;
use App\Models\Mrp\MrpProcessMachine;
use App\Models\Mrp\MrpPlanningProductionProcess;
use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpPlanningProductionProduct;
use Illuminate\Http\Request;

class MrpProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:process-list', ['only' => ['index']]);
        $this->middleware('permission:process-create', ['only' => ['create']]);
        $this->middleware('permission:process-edit', ['only' => ['edit']]);
        $this->middleware('permission:process-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Process List';
        $data['process'] = MrpProcess::orderBy('id','desc')->get();
        return view('mrp.process.process-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Process Create';
        $data['machines'] = MrpMachine::get();
        return view('mrp.process.process-create',$data);
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
            'process_code' => 'required|max:255',
            'process_name' => 'required|max:255',
            'process_time' => 'nullable',
            'machine_id' => 'nullable',
            'description' => 'nullable'
        ]);
        try {
            MrpProcess::create([
                'process_code' => $request->process_code,
                'process_name' => $request->process_name,
                'process_time' => $request->process_time,
                'description' => $request->description,
            ])->processMachines()->sync($request->get('machine_id'));
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.process-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.process-list');
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
        $data['process_machine'] = MrpProcess::findOrFail($id);
        return view('mrp.process.process-show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Process Edit';
        $data['machines'] = MrpMachine::get();
        $data['process'] = MrpProcess::findOrFail($id);
        return view('mrp.process.process-edit',$data);
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
        // dd($request->get('machine_id'));

        $validated = $request->validate([
            'process_code' => "required|max:255",
            'process_name' => "required|max:255",
            'process_time' => 'required',
            'machine_id' => 'nullable',
            'description' => "nullable"
        ]);
        try {
          $process = MrpProcess::findOrFail($id);
          
          $process->update([
                'process_code' => $request->process_code,
                'process_name' => $request->process_name,
                'process_time' => $request->process_time,
                'description' => $request->description

                
          ]);
        $process->processMachines()->sync($request->get('machine_id'));
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.process-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.process-list');
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
            MrpProcessMachine::where('process_machines_id', $request->id)->update(['process_machines_id' => null]);
            MrpPlanningProductionProcess::where('process_id', $request->id)->update(['process_id' => null]);
            MrpProcess::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }

    public function ajaxMachine(Request $request)
    {
        // $pivot1 = MrpPlanningProductionProcess::where('planning_production_id', $request->planning_id)->get();
        $pivot2 = DB::table('mrp_process_machines')->where('process_machine_id', $request->process_id)->pluck('machine_id');
        // $data = MrpProcess::whereIn('id', [$pivot2->process_id])->get();
        $data = DB::table('mrp_machines')->whereIn('id', $pivot2)->get();
        return response()->json([
            'machine' => $data
        ]);
    }
}
