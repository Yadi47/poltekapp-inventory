<?php

namespace App\Http\Controllers\Oee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OeeStockDataController extends Controller
{
    function __construct(){
        $this->middleware('permission:stock_data', ['only' => ['index']]);
    }

    public function index()
    {
        $data['page_title'] = "Stock Data";
        return view('oee.stock-data.oee-stock-data', $data);
    }
}
