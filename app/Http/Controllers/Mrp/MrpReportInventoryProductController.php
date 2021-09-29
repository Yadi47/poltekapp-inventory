<?php

namespace App\Http\Controllers\Mrp;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Excel;
use App\Models\Mrp\MrpProductSortir;
use App\Models\Mrp\MrpProductSortirOK;
use App\Models\Mrp\MrpProductSortirNG;
use App\Models\Mrp\MrpInventoryProductIncoming;
use App\Models\Mrp\MrpInventoryProductOut;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrpReportInventoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()  
    {
        $this->middleware('permission:report_inventory_product-list', ['only' => ['index']]);
        $this->middleware('permission:report_inventory_product-export', ['only' => ['export_excel']]);
    }
    public function index(Request $request)
    {

        $data['page_title'] = 'Report Inventory Product';

        $data_start = date('Y-m-d', strtotime($request->start_date));
        $data_end = date('Y-m-d', strtotime($request->end_date));
        
        $data['allinvenproduct'] = [];
        
        if ($data_start && $data_end) {
        // product incoming
        $product_incoming = MrpInventoryProductIncoming::whereBetween('created_at', [$data_start, $data_end])->get();
        foreach ($product_incoming as $pi) {
            $dpi = [];
            $dpi['product_name'] = optional($pi)->inventoryProductList->product->product_name;
            // $dpi['part_name'] = optional($pi)->inventoryProductList->material->part_name;
            $dpi['part_number'] = optional($pi)->inventoryProductList->product->part_number;
            $dpi['qty'] = optional($pi)->product_incoming;
            $dpi['pic'] = optional($pi)->employee->employee_name;
            $dpi['date'] = date('Y-m-d', strtotime(optional($pi)->created_at));
            $dpi['from'] = 'Inventory Product Incoming';
            array_push($data['allinvenproduct'], $dpi);
        }

        // product out
        $product_outgoing = MrpInventoryProductOut::whereBetween('created_at', [$data_start, $data_end])->get();
        foreach ($product_outgoing as $po) {
            $dpo = [];
            $dpo['product_name'] = optional($po)->productList->product->product_name;
            // // $dpo['part_name'] = optional($po)->productList->product->part_name;
            $dpo['part_number'] = optional($po)->productList->product->part_number;
            $dpo['qty'] = optional($po)->product_outgoing;
            $dpo['pic'] = optional($po)->employee->employee_name;
            $dpo['date'] = date('Y-m-d', strtotime(optional($po)->created_at));
            $dpo['from'] = 'Inventory Product Outgoing';

            array_push($data['allinvenproduct'], $dpo);

        }

        // product sortir
        $product_sortir = MrpProductSortir::whereBetween('created_at', [$data_start, $data_end])->get();
        foreach ($product_sortir as $ps) {
            $dps = [];
            $dps['product_name'] = optional($ps)->inventoryProductList->product->product_name;
            // // $dps['part_name'] = optional($ps)->inventoryProductList->product->part_name;
            $dps['part_number'] = optional($ps)->inventoryProductList->product->part_number;
            $dps['qty'] = optional($ps)->qty_sortir;
            $dps['pic'] = optional($ps)->employee->employee_name;
            $dps['date'] = date('Y-m-d', strtotime(optional($ps)->created_at));
            $dps['from'] = 'Product Sortir';

            array_push($data['allinvenproduct'], $dps);

        }

        // product sortir ok
        $product_sortir_ok = MrpProductSortirOK::whereBetween('created_at', [$data_start, $data_end])->get();
        foreach ($product_sortir_ok as $psok) {
            $dpsok = [];
            $dpsok['product_name'] = optional($psok)->inventoryProductList->product->product_name;
            // // $dpsok['part_name'] = optional($psok)->inventoryProductList->product->part_name;
            $dpsok['part_number'] = optional($psok)->inventoryProductList->product->part_number;
            $dpsok['qty'] = optional($psok)->qty_ok;
            $dpsok['pic'] = optional($psok)->employee->employee_name;
            $dpsok['date'] = date('Y-m-d', strtotime(optional($psok)->created_at));
            $dpsok['from'] = 'Product Sortir OK';


            array_push($data['allinvenproduct'], $dpsok);
        }
        
        // product sortir ng
        $product_sortir_ng = MrpProductSortirNG::whereBetween('created_at', [$data_start, $data_end])->get();
        foreach ($product_sortir_ng as $psng) {
            $dpsng = [];
            $dpsng['product_name'] = optional($psng)->inventoryProductList->product->product_name;
             // $dpsng['part_name'] = optional($psng)->inventoryProductList->product->part_name;
            $dpsng['part_number'] = optional($psng)->inventoryProductList->product->part_number;
            $dpsng['qty'] = optional($psng)->qty_ng;
            $dpsng['date'] = date('Y-m-d', strtotime(optional($psng)->created_at));
            $dpsng['pic'] = optional($psng)->employee->employee_name;
            $dpsng['from'] = 'Product Sortir NG';

            array_push($data['allinvenproduct'], $dpsng);

        }
    }
        return view('mrp.inventories.reports.report_inventory_product-list', $data);
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

    public function generateDate(){
        $tgl_awal = date('Y-m-d');
        $tgl_pertama = date('Y-m-01', strtotime($tgl_awal));
        $tgl_terakhir = date('t', strtotime($tgl_awal));
        $thn_bln = date('Y-m-');

        $tgl_sekarang = date('d');
        $data['date'] = date('F Y');


        $data = [];
        $data['output_date'] = '';
        $data['count_column'] = $tgl_terakhir;
        $data['count_tanda_tangan'] = [];
        for ($i = date('t', strtotime($tgl_awal)); $i > 0; $i-=7) { 
            if ($i - 7 > 0) {
                $data['count_tanda_tangan'][] = 7;
            } else {
                $data['count_tanda_tangan'][] = $i;
            }
        }

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
            $output_date    .= '<tr><td class="date-head" style="background:' . '">' . $tgl_index . '</td></tr>';
        };

        return $output_date;
    }
    public function generateColumn(){
        $tgl_awal = date('Y-m-d');
        $tgl_pertama = date('Y-m-01', strtotime($tgl_awal));
        $tgl_terakhir = date('t', strtotime($tgl_awal));
        $thn_bln = date('Y-m-');

        $tgl_sekarang = date('d');
        $data['date'] = date('F Y');

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

                $stock = MrpInventoryProductList::where('created_at', 'LIKE', '%' . $date . '%');
                
            }

            $output_date    .= '<td class="date-head" style="background:'  . '">' .  '</td>';
        };



        return $output_date;
    }

    public function generateStock(){
        $tgl_awal = date('Y-m-d');
        $tgl_pertama = date('Y-m-01', strtotime($tgl_awal));
        $tgl_terakhir = date('t', strtotime($tgl_awal));
        $thn_bln = date('Y-m-');
        $invenprod = MrpInventoryProductList::where('created_at', 'LIKE', '%' . $date . '%');

        $tgl_sekarang = date('d');
        $data['date'] = date('F Y');
        $data = [];

        foreach ($invenprod as $key => $value) {
            $data['stock'] = 0;
        }


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

            $output_date    .= '<td class="date-head" style="background:'  . '">' .  '</td>';
        };



        return $output_date;
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
        //
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
}
