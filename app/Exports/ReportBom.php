<?php

namespace App\Exports;

// use App\ReportBom;
use App\Models\Mrp\MrpReportBom;
use App\Models\Mrp\MrpBom;
use App\Models\Mrp\MrpBomMaterial;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithDrawings;


class ReportBom implements FromView, Responsable
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    // public function collection()
    // {
    //     return MrpReportBom::all();
    // }

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
        // $data['end_date'] = $this->end_date;
        $data['status'] = 'generate';
        $data['date'] =  date('Y-m-d');
        return view('mrp.boms.reports.report_bom_excel', $data);
    }

    // public function view(): View
    // {
    //     $data['boms'] = MrpBom::orderBy('id', 'desc')->get();
    //     return view('mrp.boms.reports.report_bom-list');

    // }
    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('Logo');
    //     $drawing->setDescription('This is my logo');
    //     $drawing->setPath(public_path('/itokin.png'));
    //     $drawing->setHeight(200);
    //     $drawing->setwidth(65);
    //     $drawing->setCoordinates('A2');

    //     return $drawing;
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
        $boms = MrpBomMaterial::orderBy('id', 'desc')->get();

        // dd($boms->material->material_name);
        $tgl_sekarang = date('d');

        // $total = [];
        $data = [];

        // $materialPrice = MrpMaterial::select('id', 'price')->get();
        // $qtyMaterial = 0;
        // foreach ($materialPrice as $key => $value){
        //     $qtyMaterial *= $value->bomMaterial->sum('qty_material');
        // }
        // dd($value);
        // return $qtyMaterial;
    foreach ($boms as $key => $value) {
        if ($value->bom) {
        $data[$value->id] = [];
        $data[$value->id]['bom_name'] = $value->bom->bom_name; 
        $data[$value->id]['part_number'] = $value->material->part_number;
        $data[$value->id]['price'] = $value->material->price;
        $data[$value->id]['qty_material'] = [];
        $data[$value->id]['sum_value']['qty_material'] = [];
        $data[$value->id]['td'] = [];
        $data[$value->id]['td']['qty_material'] = [];
        // $data[$value->id]['qty_material'] = $value->qty_material; 
        // dd($data);
      
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

                $actual_1 = MrpBomMaterial::where('created_at', 'LIKE', '%' . $date . '%')->where('id',$value->id)->get('qty_material')->first();
                // dd($actual_1 );     
                
                $value_actual_1 = $actual_1 ?? 0;
                
                $data[$value->id]['sum_value']['qty_material'] = $value_actual_1;
                $data[$value->id]['td']['qty_material'] = '<td class="date-head" style="background:' . $nowdatecolor . '">' . $value_actual_1 . '</td>';


            

            };
        }
    }
        return $data;
    }

}
