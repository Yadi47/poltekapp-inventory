<?php

namespace App\Exports;

use App\Models\Mrp\MrpReportProduction;
use App\Models\Mrp\MrpProduction;
use App\Models\Mrp\MrpMachine;
use App\Models\Mrp\MrpPlanningProduction;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\generateDate;
use Illuminate\Contracts\View\generateColumn;
use Illuminate\database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ReportProduction implements FromView, Responsable, WithDrawings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($start_date = null)
    {
        $this->start_date = $start_date;
    }

    public function view(): view
    {
        $data['head_date']  = $this->generateDate($this->start_date);
        $data['body_date']  = $this->generateColumnExample($this->start_date);
        $data['column'] = $this->generateColumn($this->start_date);
        $data['start_date'] = $this->start_date;
        $data['status'] = 'generate';
        $data['date'] =  date('Y-m-d');
        return view('mrp.production.reports.report_production_excel', $data);
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
    // public function startCell(): string{
    //     return 'A8';
    // }
    
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
            $output_date .= '<td class="date-head" style="background:' . $nowdatecolor . '; width :14px">' . rand(0, 000) . '</td>';
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

                $actual_1 = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('shift_id', 1)->where('machine_id', $value->id)->pluck('qty_entry')->first();
                $actual_2 = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('shift_id', 2)->where('machine_id', $value->id)->pluck('qty_entry')->first();
                $plan_1 = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('shift_id', 1)->where('machine_id', $value->id)->pluck('qty_plan')->first();
                $plan_2 = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('shift_id', 2)->where('machine_id', $value->id)->pluck('qty_plan')->first();
                $ng_1 = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('shift_id', 1)->where('machine_id', $value->id)->pluck('qty_reject')->first();
                $ng_2 = MrpProduction::where('created_at', 'LIKE', '%' . $date . '%')->where('shift_id', 2)->where('machine_id', $value->id)->pluck('qty_reject')->first();

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
