<?php

namespace App\Http\Controllers\Mrp;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mrp\MrpProduction;
use App\Models\Mrp\MrpMachine;
use App\Models\Mrp\MrpWipProcess;
use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpBom;
use App\Models\Mrp\MrpShift;
use App\Models\Mrp\MrpReportProduction;
use App\Models\Mrp\MrpReportPlanningProduction;
use App\Models\Mrp\MrpPlanningProduction;
use App\Models\Mrp\MrpPlanningProductionProduct;
use Maatwebsite\Excel\Excel;
use App\Exports\ReportProduction;
use App\Exports\ReportPlanningProduction;
use Carbon\Carbon;
use DateTime;
class MrpReportPlanningProductionController extends Controller
{
    
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;

        $this->middleware('permission:report_planning_production-list', ['only' => ['index']]);
        $this->middleware('permission:report_planning_production-export', ['only' => ['export']]);
    }

    public function index(Request $request)
    {
        $data['page_title'] = 'Report Planning Production ';
        $data['head_date']  = $this->generateDate($request->start_date);
        $data['body_date']  = $this->generateColumnExample($request->start_date);
        $data['productions'] = MrpProduction::orderBy('id', 'desc')->get();

        if ($request->get('start_date')) {
            // $data['productions'] = MrpProduction::where('created_at', '>=', $request->start_date)->where('created_at', '<=', $request->end_date)->get();
            // $data['column'] = $this->generateColumn($request->start_date);
            // // dd($data['column']);
            // $data['month_year'] = Carbon::parse($request->start_date)->locale('id_ID')->isoFormat('MMMM Y');
            // $data['start_date'] = $request->start_date;
            // $data['end_date'] = $request->end_date;
            // $data['status'] = 'generate';
            // $data['date'] =  date('Y-m-d');
            // return view('mrp.production.report_planning.report_planning_production-list', $data);
            $data['productions'] = MrpProduction::where('date_start', 'like', '%' . $request->get("start_date") . '%')->orderBy('id', 'desc')->get();
        }
        // HEAD DATE
        return view('mrp.production.report_planning.report_planning_production-list', $data);
        // return view('mrp.production.reports.report_production_example', $data);
    }


    public function detail($id){
        $data['page_title'] = 'Detail Production';
           $data['start_date'] = '12';
            $data['end_date'] = '12';
            $data['month_year'] ='32';
            $data['date'] =  date('Y-m-d');

        $production = MrpProduction::find($id);
        $productionProcessMachine = $production->productionProcessMachineProduct;

        $shifts = MrpShift::get();
        $begin = new DateTime($production->date_start);
        $end   = new DateTime($production->date_finish);
        $dateListHeader = [];
        $dateList = [];
        $dateColor = [];
        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            $timestamp = strtotime($i->format("Y-m-d"));
            $weekday = date("l", $timestamp);
            $normalized_weekday = strtolower($weekday);
            if (($normalized_weekday == "saturday") || ($normalized_weekday == "sunday")) {
                $nowdatecolor = '#CF8AAD';
            } else {
                $nowdatecolor = '#FFFFFF';
            }
            array_push($dateColor, $nowdatecolor);
            array_push($dateList, $i->format("Y-m-d"));
            array_push($dateListHeader, $i->format("d"));
        }

        $listProcessProduct = [];
        foreach ($productionProcessMachine as $key => $value) {
            $productWip = [];
            $dwip = [
                'from_wip' => [],
                'from_oee' => [],
            ];

            if (!array_key_exists($value->process->process_name, $listProcessProduct)) {
                $listProcessProduct[$value->process->process_name] = [];
            }

            if (!array_key_exists($value->machine->machine_name, $listProcessProduct[$value->process->process_name])) {
                $listProcessProduct[$value->process->process_name][$value->machine->machine_name] = [];
            }

            // --- get untuk product plan dari planning products
            try {
                //code...
                $planAll = $production->planning->oneProduct($production->planning->id, $value->product->id)->first()->pivot->quantity;
            } catch (\Throwable $th) {
                //throw $th;
                $planAll = 0;
            }

            $sumPlanTotal = 0;
            foreach ($dateList as $dl) {
                $timestamp = strtotime($dl);
                $weekday = date("l", $timestamp);
                $normalized_weekday = strtolower($weekday);
                if (($normalized_weekday == "saturday") || ($normalized_weekday == "sunday")) {
                    $nowdatecolor = '#CF8AAD';
                } else {
                    $nowdatecolor = '#FFFFFF';
                }

                $dataWips = MrpWipProcess::where('date', $dl)->where('mrp_production_process_machine_product_id', $value->id)->orderBy('id', 'desc')->get();
                $dataProcess = [];
                if ($dataWips->count() > 0) {
                    foreach ($dataWips as $dwp) {
                        $sumPlanTotal += ($dwp->qty_plan > 0) ? $dwp->qty_plan : $planAll;
                        $dp = [];
                        $dp['date'] = $dl;
                        $dp['shift_id'] = optional($dwp)->shift_id;
                        $dp['qty_plan'] = ($dwp->qty_plan > 0) ? $dwp->qty_plan : $planAll;
                        $dp['qty_total'] = optional($dwp)->qty_total;
                        $dp['qty_good'] = optional($dwp)->qty_good;
                        $dp['qty_reject'] = optional($dwp)->qty_reject;
                        $dp['type'] = optional($dwp)->type;
                        $dp['color'] = $nowdatecolor;
                        $dp['sum_plan'] = $sumPlanTotal;
                        $dp['plan_all'] = $planAll;
                        array_push($dataProcess, $dp);
                    }
                } else {
                    $sumPlanTotal += $planAll;
                    
                    $dp = [];
                    $dp['date'] = $dl;
                    $dp['shift_id'] = '-';
                    $dp['qty_plan'] = $planAll;
                    $dp['qty_total'] = '-';
                    $dp['qty_good'] = '-';
                    $dp['qty_reject'] = '-';
                    $dp['type'] = '-';
                    $dp['color'] = $nowdatecolor;
                    $dp['sum_plan'] = $sumPlanTotal;
                    $dp['plan_all'] = $planAll;
                    array_push($dataProcess, $dp);
                }

                // --- dari OEE PLC
                $dataProcessOEE = [];
                foreach ($shifts as $shift) {
                    $dateFrom = $dl;
                    $dateTo = $dl;

                    if ($shift->over_night == 'true') {
                        $dateTo = date('Y-m-d', strtotime($dl . "+1 days"));
                    }

                    // $realOee = DB::table('oee_plc_values')
                    //     ->where('device', $value->machine->machine_code)
                    //     ->where('datetime', '>=', $dateFrom .' '.$shift->time_from.':00')
                    //     ->where('datetime', '<=', $dateTo .' '.$shift->time_to.':00')
                    //     ->orderBy('id', 'desc')
                    //     ->first();

                    $realOee = false;

                    if ($realOee) {

                        $dpo = [];
                        $dpo['date'] = $dl;
                        $dpo['shift_id'] = $shift->id;
                        $dpo['qty_plan'] = $planAll;
                        $dpo['qty_total'] = $realOee->productionquantity;
                        $dpo['qty_good'] = $realOee->passquantity;
                        $dpo['qty_reject'] = $realOee->failquantity;
                        array_push($dataProcessOEE, $dpo);
                    } else {
                        $dpo = [];
                        $dpo['date'] = $dl;
                        $dpo['shift_id'] = '-';
                        $dpo['qty_plan'] = $planAll;
                        $dpo['qty_total'] = '-';
                        $dpo['qty_good'] = '-';
                        $dpo['qty_reject'] = '-';
                        array_push($dataProcessOEE, $dpo);
                    }
                }



                array_push($dwip['from_wip'], $dataProcess);
                array_push($dwip['from_oee'], $dataProcessOEE);
            }


            $productWip[$value->product->product_name] = $dwip;

            array_push($listProcessProduct[$value->process->process_name][$value->machine->machine_name], $productWip);
        }



        // dd($listProcessProduct);    

        $data['production'] = $production;
        $data['products'] = MrpProduct::get();
        $data['boms'] = MrpBom::get();
        $data['list_process'] = $listProcessProduct;
        $data['shifts'] = $shifts;
        $data['production_process_machine'] = $production->productionProcessMachineProduct;
        $data['date_list_header'] = $dateListHeader;
        $data['date_list_color'] = $dateColor;




        return view('mrp.production.report_planning.report_planning_detail', $data);

    }


    public function export($start)
    {
        return $this->excel->download(new ReportPlanningProduction($start), 'ReportPlanningProduction.pdf');
        // return $this->excel->download(new ReportPlanningProduction($start), 'ReportPlanningProduction.xlsx');
    }

    public function export_pdf()
    {
        return $this->excel->download(new ReportProduction, 'ReportProduction.pdf', Excel::DOMPDF);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }


    public function generateDate($bulan)
    {
        $tgl_awal = date('Y-m-d', strtotime($bulan));
        $tgl_pertama = date('Y-m-01', strtotime($tgl_awal));
        $tgl_terakhir = date('t', strtotime($tgl_awal));
        $thn_bln = date('Y-m-', strtotime($bulan));

        $tgl_sekarang = date('d');

        // Fungsi Date atas
        $output_date = '';
        $tgl = 1;
        for ($i = 0; $i < $tgl_terakhir; $i++) {
            if (strlen((string)$tgl) == 1) {
                $tgl_index = '0' . $tgl++;
            } else {
                $tgl_index = $tgl++;
            }

            if ($tgl_sekarang == $tgl_index) {
                $nowdatecolor    =  '#C9D1D3';
            } else {
                $date = $thn_bln . $tgl_index;
                $timestamp = strtotime($date);
                $weekday = date("l", $timestamp);
                $normalized_weekday = strtolower($weekday);
                if (($normalized_weekday == "saturday") || ($normalized_weekday == "sunday")) {
                    $nowdatecolor = '#D98FB5';
                } else {
                    $nowdatecolor = '';
                }
            }
            $output_date    .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $tgl_index . '</td>';
        };

        return $output_date;
    }

    public function generateColumnExample($bulan)
    {
        $tgl_awal = date('Y-m-d', strtotime($bulan));
        $tgl_pertama = date('Y-m-01', strtotime($tgl_awal));
        $tgl_terakhir = date('t', strtotime($tgl_awal));
        $thn_bln = date('Y-m-', strtotime($bulan));

        $tgl_sekarang = date('d');

        // Fungsi Date atas
        $output_date = '';
        $tgl = 1;
        for ($i = 0; $i < $tgl_terakhir; $i++) {
            if (strlen((string)$tgl) == 1) {
                $tgl_index = '0' . $tgl++;
            } else {
                $tgl_index = $tgl++;
            }

            if ($tgl_sekarang == $tgl_index) {
                $nowdatecolor    =  '#C9D1D3';
            } else {
                $date = $thn_bln . $tgl_index;
                $timestamp = strtotime($date);
                $weekday = date("l", $timestamp);
                $normalized_weekday = strtolower($weekday);
                if (($normalized_weekday == "saturday") || ($normalized_weekday == "sunday")) {
                    $nowdatecolor = '#D98FB5';
                } else {
                    $nowdatecolor = '';
                }
            }
            $output_date .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . rand(0, 000) . '</td>';
        };

        return $output_date;
    }

    public function generateColumn($bulan)
    {
        $tgl_awal = date('Y-m-d', strtotime($bulan));
        $tgl_pertama = date('Y-m-01', strtotime($tgl_awal));
        $tgl_terakhir = date('t', strtotime($tgl_awal));
        $thn_bln = date('Y-m-', strtotime($bulan));
        $machines = MrpPlanningProduction::orderBy('id', 'desc')->get();
        // dd($machines[0]->process);
        

        $tgl_sekarang = date('d');
        $data = [];
        foreach ($machines as $key => $value) {
            // dd($value->product[0]->product_name);
            // $data[$value->process[0]->process_name][] = [];
            // $data[$value->product[0]->process_name]['name_name'] = $value->product[0]->product_name;
            $data[$value->process[0]->process_name]['product_name'] = [];
            $data[$value->process[0]->process_name]['process_name'] = $value->process[0]->process_name;

            $data[$value->process[0]->process_name]['product_name']['name'] = $value->product[0]->pluck('product_name')->toArray();
            
            // $data[$value->product[0]->process_name] = [];
            
            // $data[$value->machine_name] = [];
            // $data[$value->machine_name]['machine_name'] = $value->machine_name;
            $data[$value->process[0]->process_name]['sum_value'] = [];
            $data[$value->process[0]->process_name]['sum_value']['actual'] = [];
            $data[$value->process[0]->process_name]['sum_value']['actual']['shift_1'] = 0;
            $data[$value->process[0]->process_name]['sum_value']['actual']['shift_2'] = 0;
            $data[$value->process[0]->process_name]['sum_value']['plan'] = [];
            $data[$value->process[0]->process_name]['sum_value']['plan']['shift_1'] = 0;
            $data[$value->process[0]->process_name]['sum_value']['plan']['shift_2'] = 0;
            $data[$value->process[0]->process_name]['sum_value']['ng'] = [];
            $data[$value->process[0]->process_name]['sum_value']['ng']['shift_1'] = 0;
            $data[$value->process[0]->process_name]['sum_value']['ng']['shift_2'] = 0;
            $data[$value->process[0]->process_name]['td'] = [];
            $data[$value->process[0]->process_name]['td']['plan'] = [];
            $data[$value->process[0]->process_name]['td']['plan']['shift_1'] = '';
            $data[$value->process[0]->process_name]['td']['plan']['shift_2'] = '';

            // Fungsi Date atas
        
            $tgl = 1;
            
            for ($i = 0; $i < $tgl_terakhir; $i++) {
                if (strlen((string)$tgl) == 1) {
                    $tgl_index = '0' . $tgl++;
                } else {
                    $tgl_index = $tgl++;
                }

                if ($tgl_sekarang == $tgl_index) {
                    $date = $thn_bln . $tgl_index;
                    $nowdatecolor    =  '#C9D1D3';
                } else {
                    $date = $thn_bln . $tgl_index;
                    $timestamp = strtotime($date);
                    $weekday = date("l", $timestamp);
                    $normalized_weekday = strtolower($weekday);
                    if (($normalized_weekday == "saturday") || ($normalized_weekday == "sunday")) {
                        $nowdatecolor = '#D98FB5';
                    } else {
                        $nowdatecolor = '';
                    }
                }
                $date2 = "2021-08-27";
                // $actual_1 = MrpProduction::where('date_finish', 'LIKE', '%' . $date . '%')->where('shift_id', 1)->where('machine_id', $value->id)->pluck('qty_entry')->first();
                // $actual_2 = MrpProduction::where('date_finish', 'LIKE', '%' . $date . '%')->where('shift_id', 2)->where('machine_id', $value->id)->pluck('qty_entry')->first();
                // $plan_awal_1 = MrpPlanningproductionProduct::where('target_date', 'LIKE', '%' . $date . '%')->where('shift_id', 1)->get();
                // $plan_1 = $plan_awal_1[$i]->planningProductionProduct->sum('quantity');
                // dd($plan_1)[1];
                $plan_1 = MrpPlanningproductionProduct::where('created_at', 'LIKE', '%' . $date . '%')->pluck('quantity')->first();
                // $ng_1 = MrpProduction::where('date_finish', 'LIKE', '%' . $date . '%')->where('shift_id', 1)->where('machine_id', $value->id)->pluck('qty_reject')->first();
                // $ng_2 = MrpProduction::where('date_finish', 'LIKE', '%' . $date . '%')->where('shift_id', 2)->where('machine_id', $value->id)->pluck('qty_reject')->first();

                $value_actual_1 = $actual_1 ?? 0;
                $value_actual_2 = $actual_2 ?? 0;
                $value_plan_1 = $plan_1 ?? 0;
                $value_plan_2 = $plan_2 ?? 0;
                $value_ng_1 = $ng_1 ?? 0;
                $value_ng_2 = $ng_2 ?? 0;
                $data[$value->process[0]->process_name]['sum_value']['actual']['shift_1'] += $value_actual_1;
                $data[$value->process[0]->process_name]['sum_value']['actual']['shift_2'] += $value_actual_2;
                $data[$value->process[0]->process_name]['sum_value']['plan']['shift_1'] += $value_plan_1;
                $data[$value->process[0]->process_name]['sum_value']['plan']['shift_2'] += $value_plan_1;
                $data[$value->process[0]->process_name]['sum_value']['ng']['shift_1'] += $value_ng_1;
                $data[$value->process[0]->process_name]['sum_value']['ng']['shift_2'] += $value_ng_2;
                $data[$value->process[0]->process_name]['td']['plan']['shift_1'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_plan_1 . '</td>';
                $data[$value->process[0]->process_name]['td']['plan']['shift_2'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_plan_2 . '</td>';
            };
        }

        return $data;
    }
}
