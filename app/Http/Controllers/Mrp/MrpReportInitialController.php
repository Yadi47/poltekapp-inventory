<?php

namespace App\Http\Controllers\Mrp;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mrp\MrpProduction;
use App\Models\Mrp\MrpMachine;
use App\Models\Mrp\MrpShift;
use App\Models\Mrp\MrpReportProduction;
use App\Models\Mrp\MrpPlanningProduction;
use Maatwebsite\Excel\Excel;
use App\Exports\ReportProduction;
use App\Exports\ReportInitial;
class MrpReportInitialController extends Controller
{
    public function index(Request $request)
    {
        
        $data['page_title'] = 'Report Initial ';
        $data['head_date']  = $this->generateDate($request->start_date);
        $data['body_date']  = $this->generateColumnExample($request->start_date);
        if ($request->get('start_date')) {
            // $data['productions'] = MrpProduction::where('created_at', '>=', $request->start_date)->where('created_at', '<=', $request->end_date)->get();
            $data['column'] = $this->generateColumn($request->start_date);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $data['status'] = 'generate';
            $data['date'] =  date('Y-m-d');
            return view('mrp.production.report_initial.report_initial-list', $data);
        }
        // HEAD DATE
        return view('mrp.production.report_initial.report_initial-list', $data);
        // return view('mrp.production.reports.report_production_example', $data);
    }

    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $this->middleware('permission:report_initial-list', ['only' => ['index']]);
        $this->middleware('permission:report_initial-export', ['only' => ['export_excel']]);
    }
    public function export($start)
    {
        return $this->excel->download(new ReportInitial($start), 'ReportInitial.xlsx');
    }

    public function export_pdf()
    {
        return $this->excel->download(new ReportInitial, 'ReportInitial.pdf', Excel::DOMPDF);
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
        $machines = MrpMachine::orderBy('id', 'desc')->get();

        $tgl_sekarang = date('d');
        $data = [];
        foreach ($machines as $key => $value) {
            $data[$value->machine_name] = [];
            $data[$value->machine_name]['machine_name'] = $value->machine_name;
            $data[$value->machine_name]['sum_value'] = [];
            $data[$value->machine_name]['sum_value']['actual'] = [];
            $data[$value->machine_name]['sum_value']['actual']['shift_1'] = 0;
            $data[$value->machine_name]['sum_value']['actual']['shift_2'] = 0;
            $data[$value->machine_name]['sum_value']['plan'] = [];
            $data[$value->machine_name]['sum_value']['plan']['shift_1'] = 0;
            $data[$value->machine_name]['sum_value']['plan']['shift_2'] = 0;
            $data[$value->machine_name]['sum_value']['ng'] = [];
            $data[$value->machine_name]['sum_value']['ng']['shift_1'] = 0;
            $data[$value->machine_name]['sum_value']['ng']['shift_2'] = 0;
            $data[$value->machine_name]['td'] = [];
            $data[$value->machine_name]['td']['actual'] = [];
            $data[$value->machine_name]['td']['actual']['shift_1'] = '';
            $data[$value->machine_name]['td']['actual']['shift_2'] = '';
            $data[$value->machine_name]['td']['plan'] = [];
            $data[$value->machine_name]['td']['plan']['shift_1'] = '';
            $data[$value->machine_name]['td']['plan']['shift_2'] = '';
            $data[$value->machine_name]['td']['ng'] = [];
            $data[$value->machine_name]['td']['ng']['shift_1'] = '';
            $data[$value->machine_name]['td']['ng']['shift_2'] = '';

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

                $actual_1 = MrpProduction::where('date_finish', 'LIKE', '%' . $date . '%')->where('shift_id', 1)->where('machine_id', $value->id)->pluck('qty_entry')->first();
                $actual_2 = MrpProduction::where('date_finish', 'LIKE', '%' . $date . '%')->where('shift_id', 2)->where('machine_id', $value->id)->pluck('qty_entry')->first();
                $plan_1 = MrpProduction::where('date_finish', 'LIKE', '%' . $date . '%')->where('shift_id', 1)->where('machine_id', $value->id)->pluck('qty_plan')->first();
                $plan_2 = MrpProduction::where('date_finish', 'LIKE', '%' . $date . '%')->where('shift_id', 2)->where('machine_id', $value->id)->pluck('qty_plan')->first();
                $ng_1 = MrpProduction::where('date_finish', 'LIKE', '%' . $date . '%')->where('shift_id', 1)->where('machine_id', $value->id)->pluck('qty_reject')->first();
                $ng_2 = MrpProduction::where('date_finish', 'LIKE', '%' . $date . '%')->where('shift_id', 2)->where('machine_id', $value->id)->pluck('qty_reject')->first();

                $value_actual_1 = $actual_1 ?? 0;
                $value_actual_2 = $actual_2 ?? 0;
                $value_plan_1 = $plan_1 ?? 0;
                $value_plan_2 = $plan_2 ?? 0;
                $value_ng_1 = $ng_1 ?? 0;
                $value_ng_2 = $ng_2 ?? 0;
                $data[$value->machine_name]['sum_value']['actual']['shift_1'] += $value_actual_1;
                $data[$value->machine_name]['sum_value']['actual']['shift_2'] += $value_actual_2;
                $data[$value->machine_name]['sum_value']['plan']['shift_1'] += $value_plan_1;
                $data[$value->machine_name]['sum_value']['plan']['shift_2'] += $value_plan_1;
                $data[$value->machine_name]['sum_value']['ng']['shift_1'] += $value_ng_1;
                $data[$value->machine_name]['sum_value']['ng']['shift_2'] += $value_ng_2;
                $data[$value->machine_name]['td']['actual']['shift_1'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_actual_1 . '</td>';
                $data[$value->machine_name]['td']['actual']['shift_2'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_actual_2 . '</td>';
                $data[$value->machine_name]['td']['plan']['shift_1'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_plan_1 . '</td>';
                $data[$value->machine_name]['td']['plan']['shift_2'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_plan_2 . '</td>';
                $data[$value->machine_name]['td']['ng']['shift_1'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_ng_1 . '</td>';
                $data[$value->machine_name]['td']['ng']['shift_2'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_ng_2 . '</td>';
            };
        }

        return $data;
    }
}
