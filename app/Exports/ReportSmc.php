<?php

namespace App\Exports;

use App\Models\Mrp\MrpCustomerDocsCd;
use App\Models\Mrp\MrpForecast;
use Date;
use App\Models\Mrp\MrpPlanningProduction;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
// use Maatwebsite\Excel\Concerns\FromQuery;
use DateTime;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportSmc implements FromView, Responsable, WithEvents
{
    use Exportable;

    protected $start_date;
    protected $end_date;

    public function __construct($start_date = null, $end_date = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    
    public function registerEvents(): array
    {
        return[
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getStyle('A2:AH4')->applyFromArray([
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
        $data['sum'] = $this->columnSum($this->start_date, $this->end_date);
        $data['header_date'] = $this->headerDate($this->start_date, $this->end_date);
        return view('mrp.customers.reports.report_smc_excel', $data);
    }

    public function columnSum($first_date, $last_date)
    {
        $start_date = new DateTime(date('Y/m/d', strtotime($first_date)));
        $end_date = new DateTime(date('Y/m/d', strtotime($last_date)));

        $normalize_start = date('Y-m-d', strtotime($first_date));
        $normalize_end = date('Y-m-d', strtotime($last_date));
        $query = MrpForecast::select('product_id', 'customer_id')->whereBetween('forecast_date', [$normalize_start, $normalize_end])->groupBy('product_id', 'customer_id')->get();

        $data = [];
        $data['col'] = '';
        $data['sum_value'] = 0;
        $data['output_data'] = '';

        $sums = [];

        // dd($query);  

        foreach ($query as $result) {
            // dd($result->customer->dock_cd);
            $td_date = '';
            for ($date = clone $start_date; $date <= $end_date; $date->modify('+1 day')) {

                $now_date = clone $date;
                $sum = MrpForecast::whereBetween('forecast_date', [$now_date->format('Y-m-d 00:00:00'), $now_date->format('Y-m-d 23:59:59')])->where('customer_id', $result->customer_id)->sum('qty_forecast');
                $td_date .= '<td class="text-center" >' . $sum . '</td>';
            }
            $dock = MrpCustomerDocsCd::where('customer_id', $result->customer_id)->get('dock_cd')->toArray();
            $listDock = "<ul>";
            foreach ($dock as $key => $value) {
                $listDock .= "<li>". ($key+1). '.'. $value['dock_cd'] . "</li>";
            }
            $listDock .= "</ul>";

            $data['col'] .= '<tr><td class="text-center">' . $result->customer->customer_name . '</td><td class="text-center">' . $listDock . '</td><td class="text-center">' . $result->product->part_name . '</td><td class="text-center">' . $result->product->part_number . '</td>' . $td_date . '</tr>';
        }
        return $data;
    }


    public function headerDate($start_date, $end_date)
    {
        $data = [];
        $awal = new DateTime(date('Y/m/d', strtotime($start_date)));
        $akhir = new DateTime(date('Y/m/d', strtotime($end_date)));

        for ($date = clone $awal; $date <= $akhir; $date->modify('+1 day')) {

            $now_date = clone $date;
            array_push($data, $now_date->format('d-F-Y'));
        }

        return $data;
    }

}
