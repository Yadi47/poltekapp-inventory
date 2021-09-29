<?php

namespace App\Providers;

use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpProduction;
use App\Models\Mrp\MrpShift;
use Illuminate\Support\Carbon;
use App\Models\Oee\OeeMachine;
use App\Models\Oee\OeeSetProduct;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        try {
            // dd(OeeMachine::orderBy('index')->with('oeeAlarmMaster')->get());
            view()->share('oee_machines', OeeMachine::orderBy('index')->with('oeeAlarmMaster.alarms')->with('oeeAlarmMaster.alarms')->get());
            view()->share('list_products', MrpProduct::get());
            view()->share('list_productions', MrpProduction::orderBy('id','desc')->get());

            
            // --- GET SHIFT 
            $data['shifts'] = MrpShift::where('status','!=','0')->get();
            // dd($data['shifts']);
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
                $dataShift['running_operation'] = $date->running_operation;
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
            view()->share('shift', $shiftNow['shift']);


            // --- get set product
            // -- check shift
            if (count($shiftNow['shift']) === 0) {
                view()->share('set_product', []);
            } else {
                $setProduct = OeeSetProduct::where('shift_id', $shiftNow['shift'][0]['id'] ?? $shiftNow['shift'][1]['id'])
                ->where('created_at','like','%'.date('Y-m-d').'%')
                ->orderBy('id','desc')->first();
                // $setProduct = DB::table('oee_set_products')->where('shift_id', $shiftNow['shift'][0]['id'] ?? $shiftNow['shift'][1]['id'])->orderBy('id','desc')->first();
                view()->share('set_product', $setProduct);
            };
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th->getMessage());
        }

        // dd(date('Y-m-d H:i:s'));
        

    }
}
