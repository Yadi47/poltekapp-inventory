<?php

namespace App\Http\Controllers\oee;

use App\Http\Controllers\Controller;
use App\Models\Oee\OeeMachine;
use Illuminate\Http\Request;
use App\Models\Mrp\MrpShift;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class OeeDashboardController extends Controller
{
    function __construct(){
        $this->middleware('permission:oee-dashboard', ['only' => ['index']]);
        $this->middleware('permission:pde-dashboard', ['only' => ['pde']]);
        $this->middleware('permission:summary-dashboard', ['only' => ['summary']]);
    }

    public function index(){
        $data['page_title'] = "Dashboard OEE";
       
        // $data['shifts'] = MrpShift::get();
        // $dataShifts = [];


        // foreach ($data['shifts'] as $date) {
        //     $time1 = strtotime($date->time_from . ':00');
        //     $time2 = strtotime($date->time_to . ':00');
        //     $interval = $time2-$time1;

        //     if ($interval < 0) {
        //         $star_shift = '2020-01-01 ' . $date->time_from . ':00';
        //         $end_shift = '2020-01-02 ' . $date->time_to . ':00';
        //     } else {
        //         $star_shift = '2020-01-01 ' .    $date->time_from . ':00';
        //         $end_shift = '2020-01-01 ' .     $date->time_to . ':00';
        //     }

        //     $dataShift = [];
        //     $dataShift['start'] = $star_shift; 
        //     $dataShift['stop'] = $end_shift; 
        //     $dataShift['shift'] = $date->shift_name; 
        //     $dataShift['interval'] = $interval;

        //     array_push($dataShifts, $dataShift);
        // }

        // $jam = '2020-01-01 ' . Carbon::now()->format('H:i:s');
        // $shiftNow['shift'] = array_filter($dataShifts, function($s) use ($jam) {
        //     if (($jam >= $s['start']) && ($jam <= $s['stop'])) {
        //         return $s['shift'];

        //     } else {
        //         $jam = '2020-01-02 ' . Carbon::now()->format('H:i:s');
        //         if (($jam >= $s['start']) && ($jam <= $s['stop'])) {

        //             return $s['shift'];
                    
        //         } else {
                
        //         }
        //     }
        // });

        return view('oee.dashboard.oapq.oee-dashboard-oapq',$data );
    }
    public function detail($id){
        $oeeMachine = OeeMachine::where('name',$id)->first();
        $data['page_title'] = "Dashboard Detail " .$oeeMachine->ident;
        
        // $data['shifts'] = MrpShift::get();
        // $dataShifts = [];

        // $test = $data['shifts']->filter(function($shift) use ($time_now){
        //     if ($shift->time_to > $shift->time_from && $time_now >= $shift->time_from && $time_now < $shift->time_to) {
        //         return $shift;
                
        //     } else if ($shift->time_to < $shift->time_from && ($time_now < $shift->time_to || $shift->time_from)) {

        //         return $shift;
        //     }
        // });


        // foreach ($data['shifts'] as $date) {
        //     $time1 = strtotime($date->time_from . ':00');
        //     $time2 = strtotime($date->time_to . ':00');
        //     $interval = $time2-$time1;

        //     if ($interval < 0) {
        //         $star_shift = '2020-01-01 '. $date->time_from . ':00';
        //         $end_shift = '2020-01-02 '. $date->time_to . ':00';
        //     } else {
        //         $star_shift = '2020-01-01 '. $date->time_from . ':00';
        //         $end_shift = '2020-01-01 '. $date->time_to . ':00';
        //     }

        //     $dataShift = [];
        //     $dataShift['start'] = $star_shift; 
        //     $dataShift['stop'] = $end_shift; 
        //     $dataShift['shift'] = $date->shift_name; 
        //     $dataShift['interval'] = $interval;

        //     array_push($dataShifts, $dataShift);
        // }

        // $jam = '2020-01-01 '.Carbon::now()->format('H:i:s');
        // $shiftNow['shift'] = array_filter($dataShifts, function($s) use ($jam) {
        //     if (($jam >= $s['start']) && ($jam <= $s['stop'])) {
        //         return $s['shift'];
        //     } else {
        //         $jam = '2020-01-02 ' . Carbon::now()->format(' H:i:s');
        //         if (($jam >= $s['start']) && ($jam <= $s['stop'])) {

        //             return $s['shift'];
                    
        //         } else {
                
        //         }
        //     }
        // });

        $data['machine'] = $oeeMachine;
        return view('oee.dashboard.oapq.oee-dashboard-detail',$data);
    }
    public function pde(){
        $data['page_title'] = "Dashboard Product Out";
        return view('oee.dashboard.pde.oee-dashboard-pde',$data);
    }
    public function defectRate(){
        $data['page_title'] = "Dashboard Defect Rate";
        return view('oee.dashboard.defect-rate.oee-dashboard-defect-rate',$data);
    }
    public function summary()
    {
        $data['page_title'] = "Summary Dashboard";
        return view('oee.dashboard.summary.summary-dashboard', $data);
    }

    public function productionTrend(Request $request){
        $machine = $request->get('name');
        $date = $request->get('date_from');
        $date2 = $request->get('date_to');

        if($request->type === 'monthly'){
            $dataLogs = DB::table('oee_plc_values')
            ->select(DB::raw("
            date_trunc('day',datetime) AS dttime ,
            max(productionquantity) as total_qty,
            max(passquantity) as good_qty,
            max(failquantity) as reject_qty,
            max(runningtimesecond) as running_second,
            max(runningtimesecond)/60 as running_minute,
            max(runningtimehour) as running_hour,
            max(abnormalytimesecond)/60 as abnormaly_time_minute,
            max(abnormalytimesecond) as abnormaly_time_second,
            max(station1) as st1,
            max(station1up) as st1up,
            max(station2) as st2,
            max(station3_high) as st3_high,
            max(station3_low) as st3_low,
            max(station3_height) as st3_height,
            max(station3up_height) as st3up_height,
            max(station3_noball) as st3_noball,
            max(station3_twoball) as st3_twoball,
            max(station5_height) as st5_height,
            max(station5_high) as st5_high,
            max(station5_low) as st5_low,
            max(station6_high) as st6_high,
            max(station6_low) as st6_low,
            max(station8_high) as st8_high,
            max(station8_low) as st8_low,
            max(station9_interface) as st9_interface,
            max(station10_high) as st10_high,
            max(station10_low) as st10_low,
            max(station10_direction) as st10_direction,
            max(station10_presshigh) as st10_presshigh,
            max(station10_presslevel) as st10_presslevel,
            max(station11_presslow) as st11_presslow,
            max(station11_presslevel) as st11_presslevel,

            min(device) as device_id
            "))
            // ->where("datetime", ">=", $date.' 00:00:00')
            // ->where("datetime", "<=", $date.' 23:59:59')
            ->where("datetime", "like", $date . '%')
            ->where("device", $machine)
            ->where("runningtimesecond",'>',0)
            ->groupBy('dttime')
            ->groupBy('dttime')
            ->groupBy('device')
            ->orderBy('dttime', 'asc')
            ->get()->toArray();
        }else if($request->type === 'daily'){
            $dataLogs = DB::table('oee_plc_values')
            ->select(DB::raw("
                date_trunc('hour',datetime) +
                (((date_part('minute', datetime)::integer / 60::integer) * 60::integer)
                || 'minutes')::interval AS dttime ,
                max(productionquantity) as total_qty,
                max(passquantity) as good_qty,
                max(failquantity) as reject_qty,
                max(runningtimesecond) as running_second,
                max(runningtimesecond)/60 as running_minute,
                max(runningtimehour) as running_hour,
                max(abnormalytimesecond)/60 as abnormaly_time_minute,
                max(abnormalytimesecond) as abnormaly_time_second,
                max(station1) as st1,
                max(station1up) as st1up,
                max(station2) as st2,
                max(station3_high) as st3_high,
                max(station3_low) as st3_low,
                max(station3_height) as st3_height,
                max(station3up_height) as st3up_height,
                max(station3_noball) as st3_noball,
                max(station3_twoball) as st3_twoball,
                max(station5_height) as st5_height,
                max(station5_high) as st5_high,
                max(station5_low) as st5_low,
                max(station6_high) as st6_high,
                max(station6_low) as st6_low,
                max(station8_high) as st8_high,
                max(station8_low) as st8_low,
                max(station9_interface) as st9_interface,
                max(station10_high) as st10_high,
                max(station10_low) as st10_low,
                max(station10_direction) as st10_direction,
                max(station10_presshigh) as st10_presshigh,
                max(station10_presslevel) as st10_presslevel,
                max(station11_presslow) as st11_presslow,
                max(station11_presslevel) as st11_presslevel,

                min(device) as device_id
                "))
            ->where("datetime", ">=", $date.' 00:00:00')
            ->where("datetime", "<=", $date2.' 23:59:59')
            ->where("productionquantity", ">", 0)
            // ->where("datetime", "like", $date.'%')
            ->where("device", $machine)
            ->groupBy('dttime')
                ->groupBy('dttime')
                ->groupBy('device')
                ->orderBy('dttime', 'asc')
                ->get()->toArray();
        }else{
            $dataLogs = DB::table('oee_plc_values')
            ->select(DB::raw("
                date_trunc('hour',datetime) +
                (((date_part('minute', datetime)::integer / 60::integer) * 60::integer)
                || 'minutes')::interval AS dttime ,
                max(productionquantity) as total_qty,
                max(passquantity) as good_qty,
                max(failquantity) as reject_qty,
                max(runningtimesecond) as running_second,
                max(runningtimesecond)/60 as running_minute,
                max(runningtimehour) as running_hour,
                max(abnormalytimesecond)/60 as abnormaly_time_minute,
                max(abnormalytimesecond) as abnormaly_time_second,
                max(station1) as st1,
                max(station1up) as st1up,
                max(station2) as st2,
                max(station3_high) as st3_high,
                max(station3_low) as st3_low,
                max(station3_height) as st3_height,
                max(station3up_height) as st3up_height,
                max(station3_noball) as st3_noball,
                max(station3_twoball) as st3_twoball,
                max(station5_height) as st5_height,
                max(station5_high) as st5_high,
                max(station5_low) as st5_low,
                max(station6_high) as st6_high,
                max(station6_low) as st6_low,
                max(station8_high) as st8_high,
                max(station8_low) as st8_low,
                max(station9_interface) as st9_interface,
                max(station10_high) as st10_high,
                max(station10_low) as st10_low,
                max(station10_direction) as st10_direction,
                max(station10_presshigh) as st10_presshigh,
                max(station10_presslevel) as st10_presslevel,
                max(station11_presslow) as st11_presslow,
                max(station11_presslevel) as st11_presslevel,

                min(device) as device_id
                "))
            // ->where("datetime", ">=", $date.' 00:00:00')
            // ->where("datetime", "<=", $date2.' 23:59:59')
            ->where("datetime", "like", $date.'%')
            ->where("device", $machine)
            ->where("productionquantity",'>' ,0)
            ->groupBy('dttime')
                ->groupBy('dttime')
                ->groupBy('device')
                ->orderBy('dttime', 'asc')
                ->get()->toArray();
        }
        $dataTrend = [
            'times' => [],
            'running' => [],
            'downtime'=> [],
            'production_output' => [],
            'production_good' => [],
            'production_plan' => [],
            'production_diff' => [],
            'production_fail' => [],
            'production_defect_rate_target' => [],
            'production_defect_rate' => [],
            'production_efficiency_target' => [],
            'production_efficiency' => [],
            'oee'=>[],
            'a'=>[],
            'p'=>[],
            'q'=>[],
            'st1'=>[],
            'st1up'=>[],
            'st2'=>[],
            'st3_high'=>[],
            'st3_low'=>[],
            'st3_height'=>[],
            'st3up_height'=>[],
            'st3_noball'=>[],
            'st3_twoball'=>[],
            'st5_height'=>[],
            'st5_high'=>[],
            'st5_low'=>[],
            'st6_high'=>[],
            'st6_low'=>[],
            'st8_high'=>[],
            'st8_low'=>[],
            'st9_interface'=>[],
            'st10_high'=>[],
            'st10_low'=>[],
            'st10_direction'=>[],
            'st10_presshigh'=>[],
            'st10_presslevel'=>[],
            'st11_presslow'=>[],
            'st11_presslevel'=>[],
        ];
        $OeeMachines = OeeMachine::orderBy('index')->where('name', $machine)->first();
        $shift = MrpShift::where('status','!=','0')->get();
        $datetime = date('Y-m-d H:i:s');
        foreach ($dataLogs as $d) {
        
            if (date('H:i:s', strtotime($d->dttime)) >= date('13:00:00') && date("H:i:s", strtotime($d->dttime)) <= date('16:30:00') || date('H:i:s', strtotime($d->dttime)) >= date('00:00:00') && date("H:i:s", strtotime($d->dttime)) <= date('05:00:00')) {
                // $_performance = (($d->total_qty * $OeeMachines->cycle_time) / ($d->running_second - (($shift[0]->total_time - $shift[0]->running_operation)*60))) * 100;
                $_availability = ((($d->running_minute + ($d->abnormaly_time_minute - ($shift[0]->total_time - $shift[0]->running_operation))) - ($d->abnormaly_time_minute - ($shift[0]->total_time - $shift[0]->running_operation))) / (($d->running_minute + ($d->abnormaly_time_minute - ($shift[0]->total_time - $shift[0]->running_operation))) ?: 1) ) * 100;

            }else{
                $_availability = ((($d->running_minute + $d->abnormaly_time_minute) - $d->abnormaly_time_minute) / (($d->running_minute + $d->abnormaly_time_minute) ?: 1) ) * 100;
            }
            $_performance = (($d->total_qty * $OeeMachines->cycle_time) /($d->running_second?:1)) * 100;
            $_quality = ($d->good_qty / ($d->total_qty ?: 1)) * 100;
            $_oee = (($_availability / 100) * ($_performance / 100) * ($_quality / 100)) * 100;
                array_push($dataTrend['times'], $d->dttime);
                array_push($dataTrend['running'], $d->running_second);
                if (date('H:i:s', strtotime($d->dttime)) >= date('13:00:00') && date("H:i:s", strtotime($d->dttime)) <= date('16:30:00') || date('H:i:s', strtotime($d->dttime)) >= date('00:00:00') && date("H:i:s", strtotime($d->dttime)) <= date('05:00:00')) {
                    // array_push($dataTrend['running'], ($d->running_second - (($shift[0]->total_time - $shift[0]->running_operation)*60)));
                    array_push($dataTrend['downtime'], $d->abnormaly_time_second - (($shift[0]->total_time - $shift[0]->running_operation)*60));
                }else{
                    array_push($dataTrend['downtime'], $d->abnormaly_time_second);
                }

                array_push($dataTrend['production_output'], $d->total_qty);
                array_push($dataTrend['production_good'], $d->good_qty);
                array_push($dataTrend['production_plan'], 8000);
                array_push($dataTrend['production_diff'], 8000 - $d->total_qty);
                array_push($dataTrend['production_fail'], $d->reject_qty);
                array_push($dataTrend['production_defect_rate_target'], 40);
                array_push($dataTrend['production_defect_rate'], ($d->reject_qty / ($d->total_qty?:1)) * 100);
                array_push($dataTrend['production_efficiency_target'], 80);
                array_push($dataTrend['production_efficiency'], ($d->good_qty / ($d->total_qty?:1)) * 100);
                array_push($dataTrend['oee'], number_format($_oee,2));
                array_push($dataTrend['a'], number_format($_availability,2));
                array_push($dataTrend['p'], number_format($_performance,2));
                array_push($dataTrend['q'], number_format($_quality,2));
                array_push($dataTrend['st1'], $d->st1);
                array_push($dataTrend['st1up'], $d->st1up);
                array_push($dataTrend['st2'], $d->st2);
                array_push($dataTrend['st3_high'], $d->st3_high);
                array_push($dataTrend['st3_low'], $d->st3_low);
                array_push($dataTrend['st3_height'], $d->st3_height);
                array_push($dataTrend['st3up_height'], $d->st3up_height);
                array_push($dataTrend['st3_noball'], $d->st3_noball);
                array_push($dataTrend['st3_twoball'], $d->st3_twoball);
                array_push($dataTrend['st5_height'], $d->st5_height);
                array_push($dataTrend['st5_high'], $d->st5_high);
                array_push($dataTrend['st5_low'], $d->st5_low);
                array_push($dataTrend['st6_high'], $d->st6_high);
                array_push($dataTrend['st6_low'], $d->st6_low);
                array_push($dataTrend['st8_high'], $d->st8_high);
                array_push($dataTrend['st8_low'], $d->st8_low);
                array_push($dataTrend['st9_interface'], $d->st9_interface);
                array_push($dataTrend['st10_high'], $d->st10_high);
                array_push($dataTrend['st10_low'], $d->st10_low);
                array_push($dataTrend['st10_direction'], $d->st10_direction);
                array_push($dataTrend['st10_presshigh'], $d->st10_presshigh);
                array_push($dataTrend['st10_presslevel'], $d->st10_presslevel);
                array_push($dataTrend['st11_presslow'], $d->st11_presslow);
                array_push($dataTrend['st11_presslevel'], $d->st11_presslevel);
        }
        return json_encode($dataTrend);
    }
}
