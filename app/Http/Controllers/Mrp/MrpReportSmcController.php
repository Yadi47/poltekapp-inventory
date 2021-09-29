<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mrp\MrpPlanningProduction;
use App\Models\Mrp\MrpCustomer;
use Maatwebsite\Excel\Excel;
use App\Exports\ReportSmc;
use App\Models\Mrp\MrpCustomerDocsCd;
use App\Models\Mrp\MrpForecast;
// use DB;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Unique;

class MrpReportSmcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $excel;
    // protected $start;
    // protected $end;
    protected $slice;
    public function __construct(Excel $excel, Request $request)
    {
        $this->excel = $excel;
        // $this->start = $request->start_date;
        // $this->end = $request->end_date;

        $this->middleware('permission:report_forcast-list', ['only' => ['index']]);
        $this->middleware('permission:report_forcast-export', ['only' => ['export_excel']]);
    }


    public function index(Request $request)
    {
        $data['page_title'] = 'Report Summary Forecast Customer List';
        if ($request->get('start_date')) {
            $data['sum'] = $this->columnSum($request->start_date, $request->end_date);
            $data['header_date'] = $this->headerDate($request->start_date, $request->end_date);
            // $data['header_month'] = $this->headerMonth($request->start_date, $request->end_date);
            $data['start_date'] = date('Y-m-01', strtotime($request->start_date));
            $data['end_date'] = date('Y-m-t', strtotime($request->end_date));
            $data['status'] = 'generate';
            return view('mrp.customers.reports.report_smc_list', $data);
        }
        return view('mrp.customers.reports.report_smc_list', $data);
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
        // $data['rowspan'] = $query->count() + 1;
        


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

    // public function headerMonth($start_date, $end_date)
    // {
    //     $data = [];
    //     $awal = new DateTime(date('Y/m/d', strtotime($start_date)));
    //     $akhir = new DateTime(date('Y/m/d', strtotime($end_date)));

    //     for ($month = clone $awal; $month <= $akhir; $month->modify('+1 day')) {
    //         $now_month = clone $month;
    //         array_push($data, $now_month->format('M'));
    //     }

    //     return $data;
    // }

    public function export_excel($start, $end)
    {
        // $start = $request->start_date;
        // $end = $request->end_date;
        return $this->excel->download(new ReportSmc($start, $end), 'ReportSummaryForecastProduction.xlsx');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    // public function monthName($start_date, $end_date)
    // {
    //     $data = [];
    //     $list_month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    //     $start_bln = date('m', strtotime($start_date));
    //     $end_bln = date('m', strtotime($end_date));
    //     $awal = $start_bln - 1;
    //     $range = $end_bln - $start_bln + 1;

    //     $slice = array_slice($list_month, $awal, $range);
    //     return $slice;
    // }

}
