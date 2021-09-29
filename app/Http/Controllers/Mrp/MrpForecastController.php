<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpCustomer;
use App\Models\Mrp\MrpForecast;
use App\Models\Mrp\MrpProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use Carbon\Carbon;
use DB;

class MrpForecastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:forecast-list', ['only' => ['index']]);
        $this->middleware('permission:forecast-create', ['only' => ['create']]);
        $this->middleware('permission:forecast-edit', ['only' => ['edit']]);
        $this->middleware('permission:forecast-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data['page_title'] = 'Forecast List';
        $data['forecasts'] = MrpForecast::orderBy('id', 'desc')->get();

        if ($request->get('start_date')) {
            $date = date('Y-m', strtotime($request->start_date));
            $data['forecasts'] = MrpForecast::where('forecast_date', 'like', '%' . $date . '%')->orderBy('id', 'desc')->get();
        }
        
        return view('mrp.forecasts.forecast-list', $data);
    }


    // public function daily_report(Request $request)
    // {
    // $start_date = Carbon::parse($request->start_date)
    //                         ->toDateTimeString();

    // $end_date = Carbon::parse($request->end_date)
    //                         ->toDateTimeString();

    // return MrpForecast::whereBetween('created_at',[$start_date,$end_date])->get();

    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['page_title'] = 'Forecast Create';
        $data['products'] = MrpProduct::get();
        $data['customers'] = MrpCustomer::get();
        return view('mrp.forecasts.forecast-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'dock_cd' => 'required|unique:mrp_forecasts|max:255, $id',
            'qty_forecast' => 'required',
            'customer_id' => 'required|max:255',
            'product_id' => 'required',
            // 'forecast_date' => 'required',
        ],
    [
        'customer_id.required' => '*Customer Wajib Diisi!',
        'qty_forecast.required' => '*Quantity Wajib Diisi!',
        'product_id.required' => '*Part Wajib Diisi!',
    ]);
        try {
            // dd($request->all());
            MrpForecast::create([
                // 'dock_cd' => $request->dock_cd,
                'qty_forecast' => $request->qty_forecast,
                'customer_id' => $request->customer_id,
                'product_id' => $request->product_id,
                'forecast_date' => date('Y-m-d', strtotime($request->forecast_date)),
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.forecast-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.forecast-list');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mrp\MrpForecast  $mrpForecast
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['forecast'] = MrpForecast::findOrFail($id);
        return view('mrp.forecasts.forecast-show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mrp\MrpForecast  $mrpForecast
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Forecast Edit';
        $data['products'] = MrpProduct::get();
        $data['customers'] = MrpCustomer::get();
        $data['forecast'] = MrpForecast::find($id);
        return view('mrp.forecasts.forecast-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mrp\MrpForecast  $mrpForecast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MrpForecast $mrpForecast, $id)
    {
        // dd($request->all());

        $validated = $request->validate([
            // 'dock_cd' => "required|max:255|unique:mrp_forecasts,dock_cd, $id",
            'qty_forecast' => 'required',
            'customer_id' => 'required',
            'product_id' => 'required',
        ],
    [
        'customer_id.required' => '*Customer Wajib Diisi!',
        'qty_forecast.required' => '*Quantity Wajib Diisi!',
        'product_id.required' => '*Part Wajib Diisi!',
    ]);
        try {
            // dd($request);
            MrpForecast::where('id', $id)->update([
                // 'dock_cd' => $request->dock_cd,
                'qty_forecast' => $request->qty_forecast,
                'customer_id' => $request->customer_id,
                'product_id' => $request->product_id,
                'forecast_date' => date('Y-m-d', strtotime($request->forecast_date)),

            ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('mrp.forecast-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.forecast-list');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mrp\MrpForecast  $mrpForecast
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MrpForecast $mrpForecast)
    {
        try {
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success');
            MrpForecast::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger');
            //throw $th;
        }
    }
}
