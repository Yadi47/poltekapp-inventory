<?php

namespace App\Exports;

// use App\MrpProduction;
use App\Models\Mrp\MrpProduction;
use App\Models\Mrp\MrpProcess;
use App\Models\Mrp\MrpMachine;
use App\Models\Mrp\MrpWipProcess;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\generateDate;
use Illuminate\Contracts\View\generateColumn;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ReportWip implements FromView, Responsable, WithEvents
{
    use Exportable;

    public function __construct($start_date = null)
    {
        $this->start_date = $start_date;
    }

    public function registerEvents(): array
    {
        return[
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getStyle('A1:K9')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000'],
                        ],
                    ]

                ]);
                // $event->sheet->getStyle('N8:AM22')->applyFromArray([
                //     'font' => [
                //         'bold' => true
                //     ],
                //     'borders' => [
                //         'allBorders' => [
                //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                //             'color' => ['argb' => '000'],
                //         ],
                //     ]

                // ]);
            }
        ];
    }

    public function view(): View
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


        $data['report_wip'] = $reportWip;
        $data['wips'] = $dataWip;
        // return view('mrp.production.reports.report_wip_ardhi', $data);
        // return view('mrp.production.reports.report_wip-list', $data);
        return view('mrp.production.reports.report_wip_excel', $data);


        $data['head_date']  = $this->generateDate($this->start_date);
        $data['body_date']  = $this->generateColumnExample($this->start_date);
        $data['column'] = $this->generateColumn($this->start_date);
        $data['process'] = MrpProcess::select('id', 'process_name')->get();
        $data['productions'] = MrpProduction::orderBy('id', 'desc')->get();
        $data['start_date'] = $this->start_date;
        $data['status'] = 'generate';
        $data['date'] =  date('Y-m-d');
        // $data['end_date'] = $this->end_date;
        return view('mrp.production.reports.report_wip_excel', $data);

        // return view('mrp.production.reports.report_wip_excel',[
        //     'productions' => MrpProduction::all()
        //     'productions' => MrpProduction::select('production_name')->whereBetween('created_at',[$this->start, $this->end])->get()
        // ]);
        
    }
    

    // public function collection()
    // {
    //     return MrpProduction::all();
    // }

    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('Logo');
    //     $drawing->setDescription('This is my logo');
    //     $drawing->setPath(public_path('/itokin.png'));
    //     $drawing->setHeight(60);
    //     $drawing->setCoordinates('A2');
        
    //     return $drawing;
    // }

        // $drawingttd1 = new Drawing();
        // $drawingttd1->setName('Logo');
        // $drawingttd1->setDescription('This is my logo');
        // $drawingttd1->setPath(public_path('/itokin.png'));
        // $drawingttd1->setHeight(60);
        // $drawingttd1->setCoordinates('h3');

        // $drawingttd2 = new Drawing();
        // $drawingttd2->setName('Logo');
        // $drawingttd2->setDescription('This is my logo');
        // $drawingttd2->setPath(public_path('/itokin.png'));
        // $drawingttd2->setHeight(60);
        // $drawingttd2->setCoordinates('i3');

        // $drawingttd3 = new Drawing();
        // $drawingttd3->setName('Logo');
        // $drawingttd3->setDescription('This is my logo');
        // $drawingttd3->setPath(public_path('/itokin.png'));
        // $drawingttd3->setHeight(60);
        // $drawingttd3->setCoordinates('j3');

        // return [$drawing,$drawingttd1,$drawingttd2,$drawingttd3];

    public function generateDate($bulan)
    {
        $tgl_awal = date('Y-m-d', strtotime($bulan));
        $tgl_pertama = date('Y-m-01', strtotime($tgl_awal));
        $tgl_terakhir = date('t', strtotime($tgl_awal));
        $thn_bln = date('Y-m-', strtotime($bulan));

        $tgl_sekarang = date('d');
        // $data['date'] = date('F Y');

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
            $output_date    .= '<td style="background:' . $nowdatecolor . '">' . $tgl_index . '</td>';
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

        $productions = MrpProduction::orderBy('id', 'desc')->get();
        $process = [];
        $dataProductions = [];

        $tgl_sekarang = date('d');
        $data = [];
        foreach ($productions as $key => $production) {
            $data[$production->production_name] = [];
            $data[$production->production_name]['production_name'] = $production->production_name;
            // $data[$production->production_name]['part_number'] = $production->product->part_number;
            foreach ($production->planning->process as $key => $value) {
                $data[$production->production_name]['process'][$value->process_name] = [];
                $data[$production->production_name]['process'][$value->process_name]['process_name'] = $value->process_name;
                $data[$production->production_name]['process'][$value->process_name]['machine_code'] = $value->machine->machine_code;
                $data[$production->production_name]['process'][$value->process_name]['sum_value'] = [];
                $data[$production->production_name]['process'][$value->process_name]['sum_value']['actual'] = [];
                $data[$production->production_name]['process'][$value->process_name]['sum_value']['actual']['shift_1'] = 0;
                $data[$production->production_name]['process'][$value->process_name]['sum_value']['actual']['shift_2'] = 0;
                $data[$production->production_name]['process'][$value->process_name]['sum_value']['plan'] = [];
                $data[$production->production_name]['process'][$value->process_name]['sum_value']['plan']['shift_1'] = 0;
                $data[$production->production_name]['process'][$value->process_name]['sum_value']['plan']['shift_2'] = 0;
                $data[$production->production_name]['process'][$value->process_name]['sum_value']['ng'] = [];
                $data[$production->production_name]['process'][$value->process_name]['sum_value']['ng']['shift_1'] = 0;
                $data[$production->production_name]['process'][$value->process_name]['sum_value']['ng']['shift_2'] = 0;
                $data[$production->production_name]['process'][$value->process_name]['td'] = [];
                $data[$production->production_name]['process'][$value->process_name]['td']['actual'] = [];
                $data[$production->production_name]['process'][$value->process_name]['td']['actual']['shift_1'] = '';
                $data[$production->production_name]['process'][$value->process_name]['td']['actual']['shift_2'] = '';
                $data[$production->production_name]['process'][$value->process_name]['td']['plan'] = [];
                $data[$production->production_name]['process'][$value->process_name]['td']['plan']['shift_1'] = '';
                $data[$production->production_name]['process'][$value->process_name]['td']['plan']['shift_2'] = '';
                $data[$production->production_name]['process'][$value->process_name]['td']['ng'] = [];
                $data[$production->production_name]['process'][$value->process_name]['td']['ng']['shift_1'] = '';
                $data[$production->production_name]['process'][$value->process_name]['td']['ng']['shift_2'] = '';
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

                    $actual_1 = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('shift_id', 1)->where('planning_id', $value->id)->pluck('qty_entry')->first();
                    $actual_2 = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('shift_id', 2)->where('planning_id', $value->id)->pluck('qty_entry')->first();
                    $plan_1 = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('shift_id', 1)->where('planning_id', $value->id)->pluck('qty_plan')->first();
                    $plan_2 = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('shift_id', 2)->where('planning_id', $value->id)->pluck('qty_plan')->first();
                    $ng_1 = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('shift_id', 1)->where('planning_id', $value->id)->pluck('qty_reject')->first();
                    $ng_2 = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('shift_id', 2)->where('planning_id', $value->id)->pluck('qty_reject')->first();

                    $value_actual_1 = $actual_1 ?? 0;
                    $value_actual_2 = $actual_2 ?? 0;
                    $value_plan_1 = $plan_1 ?? 0;
                    $value_plan_2 = $plan_2 ?? 0;
                    $value_ng_1 = $ng_1 ?? 0;
                    $value_ng_2 = $ng_2 ?? 0;
                    
                    $data[$production->production_name]['process'][$value->process_name]['sum_value']['actual']['shift_1'] += $value_actual_1;
                    $data[$production->production_name]['process'][$value->process_name]['sum_value']['actual']['shift_2'] += $value_actual_2;
                    $data[$production->production_name]['process'][$value->process_name]['sum_value']['plan']['shift_1'] += $value_plan_1;
                    $data[$production->production_name]['process'][$value->process_name]['sum_value']['plan']['shift_2'] += $value_plan_1;
                    $data[$production->production_name]['process'][$value->process_name]['sum_value']['ng']['shift_1'] += $value_ng_1;
                    $data[$production->production_name]['process'][$value->process_name]['sum_value']['ng']['shift_2'] += $value_ng_2;
                    $data[$production->production_name]['process'][$value->process_name]['td']['actual']['shift_1'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_actual_1 . '</td>';
                    $data[$production->production_name]['process'][$value->process_name]['td']['actual']['shift_2'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_actual_2 . '</td>';
                    $data[$production->production_name]['process'][$value->process_name]['td']['plan']['shift_1'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_plan_1 . '</td>';
                    $data[$production->production_name]['process'][$value->process_name]['td']['plan']['shift_2'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_plan_2 . '</td>';
                    $data[$production->production_name]['process'][$value->process_name]['td']['ng']['shift_1'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_ng_1 . '</td>';
                    $data[$production->production_name]['process'][$value->process_name]['td']['ng']['shift_2'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_ng_2 . '</td>';
                };
            }
        }

        return $data;
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
