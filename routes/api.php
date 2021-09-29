<?php

use App\Http\Controllers\oee\OeeDashboardController;
use App\Http\Controllers\Oee\OeeProductionPerformanceController;
use App\Http\Controllers\Oee\OeeSetController;
use App\Http\Controllers\Oee\OeeAlarmsController;
use App\Models\Oee\OeeMachine;
use App\Http\Controllers\Mrp\MrpInventoryProductIncomingController;
use App\Http\Controllers\Mrp\MrpInventoryProductOutController;
use App\Http\Controllers\Mrp\MrpInventoryMaterialIncomingController;
use App\Http\Controllers\Mrp\MrpInventoryMaterialOutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('oee')->name('oee.')->group(
    function () {
        Route::post('/production-performance', [OeeProductionPerformanceController::class, 'daily'])->name('production-performance.daily');
        Route::post('/production-performance-detail', [OeeProductionPerformanceController::class, 'dailyDetailDefect'])->name('production-performance-detail.daily');
        Route::post('/production-performance-detail-effeciency', [OeeProductionPerformanceController::class, 'dailyDetailEffeciency'])->name('production-performance-detail-effeciency.daily');
        Route::post('/production-trend', [OeeDashboardController::class, 'productionTrend'])->name('production-trend');
    }
);

Route::get('/get-production/{id}', [OeeSetController::class, 'getProduction'])->name('api-get-production');
Route::get('/get-oee-machines', function(){
    return OeeMachine::orderBy('index')->with('oeeAlarmMaster.alarms')->with('oeeAlarmMaster.alarms')->get();
})->name('api-get-production');
// alarm trigger store
Route::post('/store-alarm', [OeeAlarmsController::class, 'storeAlarm'])->name('api-post-alarm');

// MRP
// Inventory

// -Material
// Material In
Route::get('/material-incoming-create', [MrpInventoryMaterialIncomingController::class, 'createIncoming'])->name('create-material-incoming-api');
Route::post('/material-incoming-store', [MrpInventoryMaterialIncomingController::class, 'storeIncoming'])->name('store-material-incoming-api');

// Material In
Route::get('/material-out-create', [MrpInventoryMaterialOutController::class, 'createOut'])->name('create-material-out-api');
Route::post('/material-out-store', [MrpInventoryMaterialOutController::class, 'storeOut'])->name('store-material-out-api');

// -Product
// product in
Route::get('/product-incoming-create', [MrpInventoryProductIncomingController::class, 'createIncoming'])->name('create-incoming-api');
Route::post('/product-incoming-store', [MrpInventoryProductIncomingController::class, 'storeIncoming'])->name('store-incoming-api');

// -Product out
Route::get('/product-out-create', [MrpInventoryProductOutController::class, 'createOut'])->name('create-out-api');
Route::post('/product-out-store', [MrpInventoryProductOutController::class, 'storeOut'])->name('store-out-api');
