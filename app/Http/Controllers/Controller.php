<?php

namespace App\Http\Controllers;

use App\Models\Mrp\MrpShift;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function getShift(){
        // --- GET SHIFT 
        $data['shifts'] = MrpShift::get();
        $dataShifts = [];
        foreach ($data['shifts'] as $date) {
            $time1 = strtotime($date->time_from . ':00');
            $time2 = strtotime($date->time_to . ':00');
            $interval = $time2 - $time1;

            if ($interval < 0) {
                $star_shift = '2020-01-01 ' . $date->time_from . ':00';
                $end_shift = '2020-01-02 ' . $date->time_to . ':00';
            } else {
                $star_shift = '2020-01-01 ' .    $date->time_from . ':00';
                $end_shift = '2020-01-01 ' .     $date->time_to . ':00';
            }

            $dataShift = [];
            $dataShift['start_shift'] = $date->time_from . ':00';
            $dataShift['stop_shift'] = $date->time_to . ':00';
            $dataShift['start'] = $star_shift;
            $dataShift['stop'] = $end_shift;
            $dataShift['shift'] = $date->shift_name;
            $dataShift['interval'] = $interval;
            $dataShift['id'] = $date->id;

            array_push($dataShifts, $dataShift);
        }

        $jam = '2020-01-01 ' . Carbon::now()->format('H:i:s');
        $shiftNow['shift'] = array_filter($dataShifts, function ($s) use ($jam) {
            if (($jam >= $s['start']) && ($jam <= $s['stop'])) {
                return $s['shift'];
            } else {
                $jam = '2020-01-02 ' . Carbon::now()->format('H:i:s');
                if (($jam >= $s['start']) && ($jam <= $s['stop'])) {

                    return $s['shift'];
                } else {
                }
            }
        });

        return $shiftNow;
    }
}
