<?php

namespace App\Http\Controllers\Oee;

use App\Http\Controllers\Controller;
use App\Models\Oee\OeeMachine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class OeeMachineController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:machine-list', ['only' => ['index']]);
        $this->middleware('permission:machine-create', ['only' => ['create']]);
        $this->middleware('permission:machine-edit', ['only' => ['edit']]);
        $this->middleware('permission:machine-delete', ['only' => ['destroy']]);

    }

    public function index()
    {
        $data['page_title'] = "Display List";
        $data['machines'] = OeeMachine::orderBy('index')->get();
        return view('oee.machine.oee-machine-index', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Display Edit';
        $data['machine'] = OeeMachine::find($id);
        
        return view('oee.machine.oee-machine-edit', $data);
    }
    public function create()
    {
        $data['page_title'] = "Create Display";
        return view('oee.machine.oee-machine-create', $data);
    }

    public function update(Request $request,$id){
        $validated = $request->validate([
            'ident' => 'required|max:255',
            'name' => 'required|max:255',
            'code' => 'required|max:255',
            'index' => 'numeric',
            'status' => 'numeric',
            'target_defect_rate' => 'numeric',
            'target_effeciency' => 'numeric',
            'cycle_time' => 'numeric'
        ]);
        try {
            OeeMachine::where('id', $id)->update([
                'ident' => $request->ident,
                'name' => $request->name,
                'code' => $request->code,
                'index' => $request->index,
                'status' => $request->status,
                'target_defect_rate' => $request->target_defect_rate,
                'target_effeciency' => $request->target_effeciency,
                'cycle_time' => $request->cycle_time
            ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('oee.machine.index');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('oee.machine.index');
        }
    }

    public function store(Request $request){
        $validated = $request->validate([
            'ident' => 'required|max:255',
            'name' => 'required|max:255',
            'code' => 'required|max:255',
            'index' => 'numeric',
            'status' => 'numeric',
            'target_defect_rate' => 'numeric',
            'target_effeciency' => 'numeric',
            'cycle_time' => 'numeric'
        ]);
        try {
            OeeMachine::create([
                'ident' => $request->ident,
                'name' => $request->name,
                'code' => $request->code,
                'index' => $request->index,
                'status' => $request->status,
                'target_defect_rate' => $request->target_defect_rate,
                'target_effeciency' => $request->target_effeciency,
                'cycle_time' => $request->cycle_time
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('oee.machine.index');
        } catch (\Throwable $th) {

            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('oee.machine.index');
        }
    }

    public function destroy(Request $request)
    {
        try {
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success');
            OeeMachine::where('id', $request->id)->delete();
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
        }
    }
}
