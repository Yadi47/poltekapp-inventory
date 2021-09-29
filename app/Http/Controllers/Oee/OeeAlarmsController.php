<?php

namespace App\Http\Controllers\Oee;

use App\Http\Controllers\Controller;
use App\Models\Oee\OeeMachine;
use App\Models\Oee\OeeAlarms;
use App\Models\Oee\OeeAlarmsMaster;
use App\Models\Oee\OeeAlarmDetail;
use Illuminate\Http\Request;
use App\Imports\AlarmDetailImport;
use App\Imports\AlarmImport;
use App\Imports\AlarmMasterImport;
use Maatwebsite\Excel\Facades\Excel; 
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OeeAlarmsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:alarm-setting-list', ['only' => ['index']]);
        $this->middleware('permission:alarm-setting-create', ['only' => ['create']]);
        $this->middleware('permission:alarm-setting-edit', ['only' => ['edit']]);
        $this->middleware('permission:alarm-setting-delete', ['only' => ['destroy']]);

    }

    public function index()
    {
        $data['page_title'] = "Alarm Setting";
        $data['alarmMaster'] = OeeAlarmsMaster::orderBy('id', 'asc')->get();
        // $data['machines'] = OeeMachine::orderBy('name', 'asc')->get();
        // dd($data['alarmMaster']);
        return view('oee.alarm-setting.oee-alarm-index', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Display Edit';
        // $data['alarm'] = OeeMachine::find($id);
        $data['machines'] = OeeMachine::orderBy('index', 'asc')->get();
        $data['alarmMaster'] = OeeAlarmsMaster::find($id);
        // $data['alarms'] = OeeAlarms::where('alarm_master_id',$id)->get();
        // dd($data['alarmMaster']->alarms);      
        return view('oee.alarm-setting.oee-alarm-edit', $data);
    }
    
    public function show($id)
    {
        $data['alarmMaster'] = OeeAlarmsMaster::findOrFail($id);
        // dd($data['alarmMaster']);
        return view('oee.alarm-setting.oee-alarm-show', $data);
    }

    public function create()
    {
        $data['page_title'] = "Create Alarm";
        $data['machines'] = OeeMachine::orderBy('index', 'asc')->get();
        return view('oee.alarm-setting.oee-alarm-create', $data);
    }

    public function update(Request $request,$id){
        $validated = $request->validate([
            
        ]);
        try {
            // OeeMachine::where('id', $id)->update([
            //     'ident' => $request->ident,
            //     'name' => $request->name,
            //     'code' => $request->code,
            //     'index' => $request->index,
            //     'status' => $request->status,
            //     'target_defect_rate' => $request->target_defect_rate,
            //     'target_effeciency' => $request->target_effeciency,
            //     'cycle_time' => $request->cycle_time
            // ]);
            $ids = [];

                $data = OeeAlarms::where('alarm_master_id', $id);
                $data2 = OeeAlarmsMaster::find($id);
                $data2->delete();
                $data->delete();
                // $detail = OeeAlarms::where('alarm_master_id', $id);
                // dd($detail);

            foreach($request->array_index as $key => $value){
                if ($request->array_index[$key] != "") {
                    $adid = OeeAlarmDetail::insertGetId([
                        'index_array' => $request->array_index[$key], 
                        'text' => $request->text[$key],
                    ]);

                    array_push($ids, $adid);
                }
            }

            if (count($ids) > 0) {
                OeeAlarmsMaster::updateOrCreate([
                    'machine_id' => $request->machine_name,
                    'alarm_name' => $request->alarm_name,
                    'alarm_tag' => $request->alarm_tag,
                ])->alarms()->attach($ids);
            }

            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('oee.alarm-setting.index');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('oee.alarm-setting.index');
        }
    }

    public function store(Request $request){
        $validated = $request->validate([
            'machine_name' => 'required',
            'array_index' => 'required',
            'alarm_name' => 'required',
            'alarm_tag' => 'required',
            'text' => 'required',
        ]);
        try {
            $ids = [];

            foreach($request->array_index as $key => $value){
                if ($request->array_index[$key] != "") {
                    $adid = OeeAlarmDetail::insertGetId([
                        'index_array' => $request->array_index[$key], 
                        'text' => $request->text[$key],
                    ]);

                    array_push($ids, $adid);
                }
            }

            if (count($ids) > 0) {
                OeeAlarmsMaster::create([
                    'machine_id' => $request->machine_name,
                    'alarm_name' => $request->alarm_name,
                    'alarm_tag' => $request->alarm_tag,
                ])->alarms()->attach($ids);
            }

            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('oee.alarm-setting.index');
        } catch (\Throwable $th) {

            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('oee.alarm-setting.index');
        }
    }

    public function destroy(Request $request)
    {
        try {
            Session::flash('message', "Data Successfuly deleted !");
            Session::flash('alert-class', 'alert-success');
            OeeAlarms::where('alarm_master_id', $request->id)->update(['alarm_master_id' => null]);
            OeeAlarmsMaster::destroy($request->id);
            // OeeAlarmDetail::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            dd($th);
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
        }
    }

    public function storeAlarm(Request $request)
    {
        try {
            $insertAlarms = [
                'datetime' => date('Y-m-d H:i:s', strtotime($request->datetime)),
                'index_array' => $request->index_array,
                'text' => $request->text ?? "-",
                'abnormal' => $request->abnormal,
                'alarm_master_id' => $request->pivot['alarm_master_id'],
                'alarm_detail_id' => $request->pivot['alarm_detail_id'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            DB::table('oee_alarm_list')->insert($insertAlarms);

            $response = (object)[
                'status' => 200,
                'message' => "Succes Insert"
            ];
            return json_encode($response);
        } catch (\Throwable $th) {
            $response = (object)[
                'status' => 500,
                'message' => $th->getMessage()
            ];
            return json_encode($response);
        }
    }
    public function importAlarmDetail(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new AlarmDetailImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Zone One Price Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        } 
    }

    public function importAlarm(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new AlarmImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Zone One Price Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }
    }

    public function importAlarmMaster(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new AlarmMasterImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Zone One Price Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }
    }
}
