<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpInventoryMaterialIncoming;
use App\Models\Mrp\MrpInventoryProductIncoming;
use App\Models\Mrp\MrpPlanningProduction;
use App\Models\Mrp\MrpInventoryShipment;
use App\Models\Mrp\MrpBomMaterial;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class MrpStockDataInventoryController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:inventory_material_stock_data-list', ['only' => ['stockDataMaterial']]);
        // $this->middleware('permission:inventory_product_stock_data-list', ['only' => ['stockDataProduct']]);
    }

    public function stockDataMaterial(Request $request)
    {
        $data['page_title'] = "Stock Data Material";
        // $data['material'] = MrpInventoryMaterialList::class
        
        $data['start_date'] = $request->start_date;
        // $data['end_date'] = $request->end_date;
        $data['status'] = 'generate';

        if ($request->start_date) {
            $data_start = $request->start_date;
            $start_date = new DateTime(Carbon::parse($data_start)->format('Y/m/d'));
            $end_date = new DateTime(Carbon::parse($data_start)->endOfMonth()->format('Y/m/d'));
        }else{
            $start_date = new DateTime(date('Y/m/01 00:00:00'));
            $end_date = new DateTime(date('Y/m/t 23:59:59'));
        }

        $data['date'] = [];
        $data['stock_in_material'] = [];
        $data['stock_out_material'] = [];
        $data['diff_stock'] = [];
 
        for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
           array_push($data['date'], $day->format('d'));
            // $plan = MrpPlanningProduction::orderBy('id');
            $material_incoming = MrpInventoryMaterialIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
            $material_out = MrpBomMaterial::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
            $stock_in_material = $material_incoming->sum('material_incoming');
            // dd($stock_in);
            $stock_out_material = $material_out->sum('qty_material')  ;
            if($stock_in_material >= $stock_out_material)
            {
                $diff_stock =    $material_incoming->sum('material_incoming') - $material_out->sum('qty_material');
            }else{
                $diff_stock =  $material_out->sum('qty_material') - $material_incoming->sum('material_incoming');
                
            }
           array_push($data['stock_in_material'], $stock_in_material);
           array_push($data['stock_out_material'], $stock_out_material);
           array_push($data['diff_stock'], $diff_stock);
        }


        return view('mrp.inventories.materials.stock-data.mrp-stock-data-material', $data);

        
    }

    public function stockDataProduct(Request $request)
    {
        $data['page_title'] = "Stock Data Product";

        $data['status'] = 'generate';

        if ($request->start_date) {
            $data_start = $request->start_date;
            $start_date = new DateTime(Carbon::parse($data_start)->format('Y/m/d'));
            $end_date = new DateTime(Carbon::parse($data_start)->endOfMonth()->format('Y/m/d'));
        }else{
            $start_date = new DateTime(date('Y/m/01 00:00:00'));
            $end_date = new DateTime(date('Y/m/t 23:59:59'));
        }

        

        $data['date'] = [];
        $data['stock_in_product'] = [];
        $data['stock_out_product'] = [];
        $data['diff_stock'] = [];
 
        for($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')){
           array_push($data['date'], $day->format('d'));
            $product_incoming = MrpInventoryProductIncoming::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
            $product_out = MrpInventoryShipment::whereBetween('created_at', [$day->format('Y-m-d 00:00:00'), $day->format('Y-m-d 23:59:59')]);
            // dd($product_incoming);
            $stock_in_product = $product_incoming->sum('product_incoming');
            // dd($stock_in);
            $stock_out_product = $product_out->sum('quantity');
            if ($stock_in_product >= $stock_out_product ) 
            {
                $diff_stock = $product_incoming->sum('product_incoming') - $product_out->sum('quantity');
            } 
            else 
            {
                $diff_stock = $product_out->sum('quantity') - $product_incoming->sum('product_incoming');
            }

           array_push($data['stock_in_product'], $stock_in_product);
           array_push($data['stock_out_product'], $stock_out_product);
           array_push($data['diff_stock'], $diff_stock);
        }

        return view('mrp.inventories.products.stock-data.mrp-stock-data-product', $data);
    }

}
