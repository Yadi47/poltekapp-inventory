<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Mrp\MrpReportProduction;
use App\Models\Mrp\MrpProduction;
use App\Models\Mrp\MrpMachine;
use App\Models\Mrp\MrpPlanningProduction;
use App\Models\Mrp\MrpPlanningProductionProduct;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\generateDate;
use Illuminate\Contracts\View\generateColumn;
use Illuminate\database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;


class ReportPlanningProduction implements FromView, Responsable, WithDrawings, WithEvents
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($start_date = null)
    {
        $this->start_date = $start_date;
    }
 
    public function registerEvents(): array
    {
        return[
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getStyle('A1:M40')->applyFromArray([
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
                $event->sheet->getStyle('N8:AM22')->applyFromArray([
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
            }
        ];
    }

    public function view(): view
    {
        $data['head_date']  = $this->generateDate($this->start_date);
        $data['body_date']  = $this->generateColumnExample($this->start_date);
        $data['column'] = $this->generateColumn($this->start_date);
        $data['month_year'] = Carbon::parse($this->start_date)->locale('id_ID')->isoFormat('MMMM Y');
        $data['start_date'] = $this->start_date;
        $data['status'] = 'generate';
        $data['date'] =  date('Y-m-d');
        return view('mrp.production.report_planning.report_planning_production_excel', $data);
    }
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/itokin.png'));
        $drawing->setHeight(200);
        $drawing->setwidth(65);
        $drawing->setCoordinates('A2');

        return $drawing;
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
            // dd($value->product);
            // $data[$value->process[0]->process_name][] = [];
            $data[$value->process[0]->process_name]['process_name'] = $value->process[0]->process_name;
            // $data[$value->product[0]->process_name]['name_name'] = $value->product[0]->product_name;
            $data[$value->process[0]->process_name]['product_name'] = [];
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
            $data[$value->process[0]->process_name]['td']['actual'] = [];
            $data[$value->process[0]->process_name]['td']['actual']['shift_1'] = '';
            $data[$value->process[0]->process_name]['td']['actual']['shift_2'] = '';
            $data[$value->process[0]->process_name]['td']['plan'] = [];
            $data[$value->process[0]->process_name]['td']['plan']['shift_1'] = '';
            $data[$value->process[0]->process_name]['td']['plan']['shift_2'] = '';
            $data[$value->process[0]->process_name]['td']['ng'] = [];
            $data[$value->process[0]->process_name]['td']['ng']['shift_1'] = '';
            $data[$value->process[0]->process_name]['td']['ng']['shift_2'] = '';

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
                $data[$value->process[0]->process_name]['td']['actual']['shift_1'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_actual_1 . '</td>';
                $data[$value->process[0]->process_name]['td']['actual']['shift_2'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_actual_2 . '</td>';
                $data[$value->process[0]->process_name]['td']['plan']['shift_1'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_plan_1 . '</td>';
                $data[$value->process[0]->process_name]['td']['plan']['shift_2'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_plan_2 . '</td>';
                $data[$value->process[0]->process_name]['td']['ng']['shift_1'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_ng_1 . '</td>';
                $data[$value->process[0]->process_name]['td']['ng']['shift_2'] .= '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_ng_2 . '</td>';
            };
        }

        return $data;
    }
}
