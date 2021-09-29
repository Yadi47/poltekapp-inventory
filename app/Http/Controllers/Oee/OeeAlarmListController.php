<?php

namespace App\Http\Controllers\oee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Oee\OeeAlarmList;

class OeeAlarmListController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:alarm-list', ['only' => ['index']]);
        // $this->middleware('permission:alarm-create', ['only' => ['create']]);
        // $this->middleware('permission:alarm-edit', ['only' => ['edit']]);
        // $this->middleware('permission:alarm-delete', ['only' => ['destroy']]);

    }

    public function index(Request $request)
    {
        $data['page_title'] = "Alarm List";
        $date = date('Y-m-d');

        if($request->ajax()){
            $data['alarms'] =  OeeAlarmList::orderBy('id', 'asc')->where('datetime','like',"%{$request->date}%")->get();
            $data['alarm_maps'] = $data['alarms']->map(function ($alarm){
                $data['datetime'] = $alarm->datetime;
                $data['ident'] = $alarm->alarmMaster->machine->ident;
                $data['alarm_name'] = $alarm->alarmMaster->alarm_name;
                $data['abnormal']= $alarm->abnormal;
                $data['text']= $alarm->text;
                return (object) $data;
            });
            return $data['alarm_maps'];

        }else{
       
            $data['alarms'] =  OeeAlarmList::orderBy('id', 'asc')->where('datetime','like',"%{$date}%")->get();
        }
        

        // $data['alarms'] = OeeAlarmList::orderBy('id', 'asc')->whereBetween('created_at', [$start, $end])->get();

        return view('oee.alarm-list.oee-alarm-list', $data);
    }

    public function store(Request $request)
    {
        try {
            //Pembuatan Kode dan Expired Date
           dd($request()->all);

            $response = (object)[
                'status' => 200,
                'message' => "stock added succesfully"
            ];
        } catch (\Throwable $th) {
            $response = (object)[
                'status' => 500,
                'message' => $th->getMessage()
            ];
        }

        return json_encode($response);
    }
}
