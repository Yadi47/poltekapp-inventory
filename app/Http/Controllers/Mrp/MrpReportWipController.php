<?php

namespace App\Http\Controllers\Mrp;

use App\Exports\ReportWip;
use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpProduction;
use App\Models\Mrp\MrpMachine;
use App\Models\Mrp\MrpShift;
use App\Models\Mrp\MrpProcess;
use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpReportWip;
use App\Models\Mrp\MrpWipProcess;
use DateTime;
use Maatwebsite\Excel\Excel;
use Illuminate\Http\Request;
use DB;
class MrpReportWipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        
        // $dataWip = MrpWipProcess::select(DB::raw('sum(qty_total) as total'))
        // ->with(['ProcessMachineProduct.production' => function($query){
        //     $query->groupBy('production_name');
        // }])
        // ->groupBy('date')
        // ->get();
        // dd($dataWip);

        $dataWip = MrpWipProcess::get();

        $reportWip = [];
        foreach ($dataWip as $dw) {
            if(!array_key_exists($dw->ProcessMachineProduct->product->product_name, $reportWip)){
                $reportWip[$dw->ProcessMachineProduct->product->product_name] = [];
            }

            if(!array_key_exists($dw->ProcessMachineProduct->process->process_name, $reportWip[$dw->ProcessMachineProduct->product->product_name])){
                $reportWip[$dw->ProcessMachineProduct->product->product_name][$dw->ProcessMachineProduct->process->process_name] = [];
            }

            if(!array_key_exists($dw->ProcessMachineProduct->machine->machine_name, $reportWip[$dw->ProcessMachineProduct->product->product_name][$dw->ProcessMachineProduct->process->process_name])){
                $reportWip[$dw->ProcessMachineProduct->product->product_name][$dw->ProcessMachineProduct->process->process_name][$dw->ProcessMachineProduct->machine->machine_name] = [];
            }

            if(!array_key_exists($dw->shift->shift_name, $reportWip[$dw->ProcessMachineProduct->product->product_name][$dw->ProcessMachineProduct->process->process_name][$dw->ProcessMachineProduct->machine->machine_name])){
                $reportWip[$dw->ProcessMachineProduct->product->product_name][$dw->ProcessMachineProduct->process->process_name][$dw->ProcessMachineProduct->machine->machine_name][$dw->shift->shift_name] = [
                    [
                        
                        "dateIndex" => (int)date('d', strtotime($dw->date)),
                        "date" => $dw->date,
                        "qty_total" => $dw->qty_total,
                        "qty_plan" => $dw->qty_plan,
                        "qty_actual" => $dw->qty_actual,
                        "qty_good" => $dw->qty_good,
                        "qty_reject" => $dw->qty_reject,
                    ]
                ];
            }else{
                array_push($reportWip[$dw->ProcessMachineProduct->product->product_name][$dw->ProcessMachineProduct->process->process_name][$dw->ProcessMachineProduct->machine->machine_name][$dw->shift->shift_name],[
                    "dateIndex" => (int)date('d', strtotime($dw->date)),
                    "date" => $dw->date,
                    "qty_total" => $dw->qty_total,
                    "qty_plan" => $dw->qty_plan,
                    "qty_actual" => $dw->qty_actual,
                    "qty_good" => $dw->qty_good,
                    "qty_reject" => $dw->qty_reject,
                ]);
            }

            // $dataReportnya = [];

        };


        $data['page_title'] = 'Report WIP List';
        $data['report_wip'] = $reportWip;
        $data['wips'] = $dataWip;
        // return view('mrp.production.reports.report_wip_ardhi', $data);
        return view('mrp.production.reports.report_wip-list', $data);


        // if (isset($request->start_date) && isset($request->end_date)) {
        //     $data['productions'] = MrpProduction::where('created_at', '<=', $request->start_date)->where('created_at', '>=', $request->end_date)->get();
        // } else {
        //     $data['productions'] = MrpProduction::get();
        // }

        // $data['shifts'] = MrpShift::get();
        // $data['process'] = MrpProcess::select('id', 'process_name')->get();
        // $data['productions'] = MrpProduction::orderBy('id', 'desc')->get();

        // HEAD DATE           
        // $data['head_date']  = $this->generateDate($request->start_date);
        // $data['body_date']  = $this->generateColumnExample($request->start_date);
        if ($request->get('start_date')) {
            // dd($request->start_date);

            // $data['productions'] = MrpProduction::where('created_at', '>=', $request->start_date)->where('created_at', '<=', $request->end_date)->get();
            $data['column'] = $this->generateColumn($request->start_date);
            $data['process'] = MrpProcess::select('id', 'process_name')->get();
            $data['productions'] = MrpProduction::orderBy('id', 'desc')->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            $data['status'] = 'generate';
            $data['date'] =  date('Y-m-d');
            return view('mrp.production.reports.report_wip-list', $data);
        }
        return view('mrp.production.reports.report_wip-list', $data);
        // if ($request->get('em')) {
        //     return view('mrp.production.reports.report_wip-list', $data);
        // }

    }

    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
        $this->middleware('permission:report_wip-list', ['only' => ['index']]);
        $this->middleware('permission:report_wip_export', ['only' => ['export_excel']]);
    }

    public function export_excel()
    {
        return $this->excel->download(new ReportWip, 'ReportWip.xlsx');
    }

    public function export_pdf()
    {
        return $this->excel->download(new ReportWip, 'ReportProduction.pdf', Excel::DOMPDF);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function generateColumn($bulan)
    {
        $tgl_awal = date('Y-m-d', strtotime($bulan));
        $tgl_pertama = date('Y-m-01', strtotime($tgl_awal));
        $tgl_terakhir = date('t', strtotime($tgl_awal));
        $thn_bln = date('Y-m-', strtotime($bulan));

            
        // $dataWip = MrpWipProcess::select(DB::raw('sum(qty_total) as total'))
        // ->with(['ProcessMachineProduct.production' => function($query){
        //     $query->groupBy('production_name');
        // }])
        // ->groupBy('date')
        // ->get();
        // dd($dataWip);

        $dataWip = MrpWipProcess::get();

        $reportWip = [];
        foreach ($dataWip as $dw) {
            if(!array_key_exists($dw->ProcessMachineProduct->product->product_name, $reportWip)){
                $reportWip[$dw->ProcessMachineProduct->product->product_name] = [];
            }

            if(!array_key_exists($dw->ProcessMachineProduct->process->process_name, $reportWip[$dw->ProcessMachineProduct->product->product_name])){
                $reportWip[$dw->ProcessMachineProduct->product->product_name][$dw->ProcessMachineProduct->process->process_name] = [];
            }

            if(!array_key_exists($dw->ProcessMachineProduct->machine->machine_name, $reportWip[$dw->ProcessMachineProduct->product->product_name][$dw->ProcessMachineProduct->process->process_name])){
                $reportWip[$dw->ProcessMachineProduct->product->product_name][$dw->ProcessMachineProduct->process->process_name][$dw->ProcessMachineProduct->machine->machine_name] = [];
            }

            if(!array_key_exists($dw->shift->shift_name, $reportWip[$dw->ProcessMachineProduct->product->product_name][$dw->ProcessMachineProduct->process->process_name][$dw->ProcessMachineProduct->machine->machine_name])){
                $reportWip[$dw->ProcessMachineProduct->product->product_name][$dw->ProcessMachineProduct->process->process_name][$dw->ProcessMachineProduct->machine->machine_name][$dw->shift->shift_name] = [
                    [
                        
                        "dateIndex" => (int)date('d', strtotime($dw->date)),
                        "date" => $dw->date,
                        "qty_total" => $dw->qty_total,
                        "qty_plan" => $dw->qty_plan,
                        "qty_actual" => $dw->qty_actual,
                        "qty_good" => $dw->qty_good,
                        "qty_reject" => $dw->qty_reject,
                    ]
                ];
            }else{
                array_push($reportWip[$dw->ProcessMachineProduct->product->product_name][$dw->ProcessMachineProduct->process->process_name][$dw->ProcessMachineProduct->machine->machine_name][$dw->shift->shift_name],[
                    "dateIndex" => (int)date('d', strtotime($dw->date)),
                    "date" => $dw->date,
                    "qty_total" => $dw->qty_total,
                    "qty_plan" => $dw->qty_plan,
                    "qty_actual" => $dw->qty_actual,
                    "qty_good" => $dw->qty_good,
                    "qty_reject" => $dw->qty_reject,
                ]);
            }

            // $dataReportnya = [];
            
        };
        $data['report_wip'] = $reportWip;
        $data['wips'] = $dataWip;
        return view($data);
    }

    public function generateColumnMachine($bulan)
    {
        $tgl_awal = date('Y-m-d', strtotime($bulan));
        $tgl_pertama = date('Y-m-01', strtotime($tgl_awal));
        $tgl_terakhir = date('t', strtotime($tgl_awal));
        $thn_bln = date('Y-m-', strtotime($bulan));

        $tgl_sekarang = date('d');

        // Fungsi Date atas
        $data = [];
        $data['sum_value'] = 0;
        $data['output_date'] = '';
        $tgl = 1;
        for ($i = 0; $i < $tgl_terakhir; $i++) {
            if (strlen((string)$tgl) == 1) {
                $tgl_index = '0' . $tgl++;
            } else {
                $tgl_index = $tgl++;
            }

            if ($tgl_sekarang == $tgl_index) {
                $date = $thn_bln . $tgl_index;
                $atul = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('machine_id', 1)->pluck('qty_entry')->first();
                $nowdatecolor    =  '#C9D1D3';
            } else {
                $date = $thn_bln . $tgl_index;
                $atul = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('machine_id', 1)->pluck('qty_entry')->first();
                $timestamp = strtotime($date);
                $weekday = date("l", $timestamp);
                $normalized_weekday = strtolower($weekday);
                if (($normalized_weekday == "saturday") || ($normalized_weekday == "sunday")) {
                    $nowdatecolor = '#D98FB5';
                } else {
                    $nowdatecolor = '';
                }
            }
            $value = $atul ?? 0;
            $data['sum_value'] += $value;
            $data['output_date'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value . '</td>';
        };

        return $data;
    }
}
