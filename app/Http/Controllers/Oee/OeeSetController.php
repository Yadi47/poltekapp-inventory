<?php

namespace App\Http\Controllers\Oee;

use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpProduction;
use App\Models\Mrp\MrpShift;
use App\Models\Oee\OeeSetProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OeeSetController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:oee-set-product', ['only' => ['setProduct']]);
    }

    public function setProduct(Request $request)
    {

        try {
            // --- jika shift belum ada
            if (count($this->getShift()['shift']) === 0) {
                Session::flash('set-product-message', "Haven't entered shift yet !");
                Session::flash('alert-class', 'alert-warning');
                return redirect()->route('oee.dashboard');
            };

            $shift = $this->getShift()['shift'][0] ?? $this->getShift()['shift'][1];
            $shift_detail = MrpShift::find($shift['id']);
            $product = MrpProduct::findOrFail($request->product);
            $dataInsert['product_id'] = $product->id;
            $dataInsert['user_id'] = Auth::user()->id;
            $dataInsert['shift_id'] = $shift['id'];

            $dataInsert['product_code'] = $product->product_code;
            $dataInsert['product_name'] = $product->product_name;
            $dataInsert['part_name'] = $product->part_name;
            $dataInsert['dim_long'] = $product->dim_long;
            $dataInsert['dim_width'] = $product->dim_width;
            $dataInsert['dim_height'] = $product->dim_height;
            $dataInsert['dim_weight'] = $product->dim_weight;
            $dataInsert['color'] = $product->color;
            $dataInsert['price'] = $product->price;
            $dataInsert['description'] = $product->description;
            $dataInsert['unit'] = $product->unit->unit_name;
            $dataInsert['customer'] = $product->customer->customer_name;

            $dataInsert["shift_code"] = $shift_detail->shift_code;
            $dataInsert["shift_name"] = $shift_detail->shift_name;
            $dataInsert["time_from"] = $shift_detail->time_from;
            $dataInsert["time_to"] = $shift_detail->time_to;
            $dataInsert["running_operation"] = $shift_detail->running_operation;
            $dataInsert["total_time"] = $shift_detail->total_time;

            DB::table('oee_set_products')->insert($dataInsert);
            Session::flash('set-product-message', 'Set Product Success !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('oee.dashboard');
        } catch (\Throwable $th) {
            Session::flash('set-product-message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('oee.dashboard');
        }
    }

    public function setProduction(Request $request)
    {

        $getProduction = MrpProduction::find($request->production);

        try {
            DB::beginTransaction();
            // --- insert ke table set product
            $dataInsert['product_id'] = $getProduction->product_id;
            $dataInsert['user_id'] = Auth::user()->id;
            $dataInsert['shift_id'] = $getProduction->shift_id;
            $dataInsert["production_id"] = $getProduction->id;


            $dataInsert['product_code'] = $getProduction->product->product_code;
            $dataInsert['product_name'] = $getProduction->product->product_name;
            $dataInsert['part_name'] = $getProduction->product->part_name;
            $dataInsert['dim_long'] = $getProduction->product->dim_long;
            $dataInsert['dim_width'] = $getProduction->product->dim_width;
            $dataInsert['dim_height'] = $getProduction->product->dim_height;
            $dataInsert['dim_weight'] = $getProduction->product->dim_weight;
            $dataInsert['color'] = $getProduction->product->color;
            $dataInsert['price'] = $getProduction->product->price;
            $dataInsert['description'] = $getProduction->product->description;
            $dataInsert['unit'] = $getProduction->product->unit->unit_name;
            $dataInsert['customer'] = $getProduction->product->customer->customer_name;

            $dataInsert["shift_code"] = $getProduction->shift->shift_code;
            $dataInsert["shift_name"] = $getProduction->shift->shift_name;
            $dataInsert["time_from"] = $getProduction->shift->time_from;
            $dataInsert["time_to"] = $getProduction->shift->time_to;
            $dataInsert["running_operation"] = $getProduction->shift->running_operation;
            $dataInsert["total_time"] = $getProduction->shift->total_time;

            // DB::table('oee_set_products')->create($dataInsert);
            OeeSetProduct::create($dataInsert);
            DB::commit();
            Session::flash('set-product-message', 'Set Production Success !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('oee.dashboard');

        } catch (\Throwable $th) {
            // Woopsy
            DB::rollBack();
            Session::flash('set-product-message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('oee.dashboard');
        }
    }

    public function getProduction($id)
    {
        $getProduction = MrpProduction::find($id);

        $dataProduction = (object)[
            'production_name' => $getProduction->production_name,
            'production_code' => $getProduction->production_code,
            'planning_name' => $getProduction->planning->plan_name,
            'planning_code' => $getProduction->planning->plan_code,
            'product_code' => $getProduction->product->product_code,
            'product_name' => $getProduction->product->product_name,
            'shift_code' => $getProduction->shift->shift_code,
            'shift_name' => $getProduction->shift->shift_name,
            'qty_plan' => $getProduction->qty_plan,
        ];
        return json_encode($dataProduction);
    }
}
