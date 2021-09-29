<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\oee\OeeDashboardController;
use App\Http\Controllers\Oee\OeeMachineController;
use App\Http\Controllers\Oee\OeeProductionPerformanceController;
use App\Http\Controllers\Oee\OeeSetController;
use App\Http\Controllers\Oee\OeeAlarmsController;
use App\Http\Controllers\Oee\OeeStockDataController;
use App\Http\Controllers\Oee\OeeAlarmListController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('oee.')->middleware('auth')->group(function () {
    Route::get('/', [OeeDashboardController::class, 'index']);
    Route::get('/summary', [OeeDashboardController::class, 'summary']);
    Route::get('/dashboard', [OeeDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/{id}', [OeeDashboardController::class, 'detail'])->name('dashboard.detail');
    Route::get('/dashboard-pde', [OeeDashboardController::class, 'pde'])->name('pde');
    Route::get('/dashboard-defect-rate', [OeeDashboardController::class, 'defectRate'])->name('defectRate');
    Route::get('/production-performance', [OeeProductionPerformanceController::class, 'index'])->name('production-performance');
    Route::get('/production-performance-defect/{id}', [OeeProductionPerformanceController::class, 'detailDefect'])->name('production-performance-defect');
    Route::get('/production-performance-effeciency/{id}', [OeeProductionPerformanceController::class, 'detailEffeciency'])->name('production-performance-effeciency');
    Route::get('/stock-data', [OeeStockDataController::class, 'index'])->name('stock-data');
});
// Detail-Defect CRUD
Route::get('/get-defect', [OeeProductionPerformanceController::class, 'getDefect'])->name('get-defect');
Route::get('/create-defect', [OeeProductionPerformanceController::class, 'createDefect'])->name('create-defect');
Route::post('/store-defect', [OeeProductionPerformanceController::class, 'storeDefect'])->name('store-defect');
Route::delete('/delete-defect', [OeeProductionPerformanceController::class, 'deleteDefect'])->name('delete-defect');
// Detail Effeciency CRUD
Route::get('/get-effeciency', [OeeProductionPerformanceController::class, 'getEffeciency'])->name('get-effeciency');
Route::get('/create-effeciency', [OeeProductionPerformanceController::class, 'createEffeciency'])->name('create-effeciency');
Route::post('/store-effeciency', [OeeProductionPerformanceController::class, 'storeEffeciency'])->name('store-effeciency');
Route::delete('/delete-effeciency', [OeeProductionPerformanceController::class, 'deleteEffeciency'])->name('delete-effeciency');

// Route::post('/store-alarm', [OeeProductionPerformanceController::class, 'storeEffeciency'])->name('store-effeciency');

Route::name('oee.machine.')->prefix('machine')->middleware('auth')->group(function () {
    Route::get('/', [OeeMachineController::class, 'index'])->name('index');
    Route::get('/create', [OeeMachineController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [OeeMachineController::class, 'edit'])->name('edit');
    Route::post('/store', [OeeMachineController::class, 'store'])->name('store');
    Route::delete('/delete', [OeeMachineController::class, 'destroy'])->name('delete');
    Route::patch('/update/{id}', [OeeMachineController::class, 'update'])->name('update');
    
});

Route::name('oee.alarm-setting.')->prefix('alarm-setting')->middleware('auth')->group(function () {
    Route::get('/', [OeeAlarmsController::class, 'index'])->name('index');
    Route::get('/create', [OeeAlarmsController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [OeeAlarmsController::class, 'edit'])->name('edit');
    Route::post('/store', [OeeAlarmsController::class, 'store'])->name('store');
    Route::delete('/delete', [OeeAlarmsController::class, 'destroy'])->name('delete');
    Route::patch('/update/{id}', [OeeAlarmsController::class, 'update'])->name('update');
    Route::get('/alarm-show/detail/{id}', [OeeAlarmsController::class, 'show'])->name('show');
    Route::post('/import-alarm-detail', [OeeAlarmsController::class, 'importAlarmDetail'])->name('detail');
    Route::post('/import-alarm', [OeeAlarmsController::class, 'importAlarm'])->name('alarm');
    Route::post('/import-alarm-master', [OeeAlarmsController::class, 'importAlarmMaster'])->name('master');
});

Route::name('oee.alarm-list.')->prefix('alarm-list')->middleware('auth')->group(function () {
    Route::get('/', [OeeAlarmListController::class, 'index'])->name('index');
    // Route::get('/create', [OeeAlarmsController::class, 'create'])->name('create');
    // Route::get('/edit/{id}', [OeeAlarmsController::class, 'edit'])->name('edit');
    // Route::post('/store', [OeeAlarmsController::class, 'store'])->name('store');
    // Route::delete('/delete', [OeeAlarmsController::class, 'destroy'])->name('delete');
    // Route::patch('/update/{id}', [OeeAlarmsController::class, 'update'])->name('update');
    // Route::get('/alarm-show/detail/{id}', [OeeAlarmsController::class, 'show'])->name('show');
    
});

Route::name('oee.set.')->prefix('set')->middleware('auth')->group(function(){
    Route::post('/product', [OeeSetController::class, 'setProduct'])->name('product');
    Route::post('/production', [OeeSetController::class, 'setProduction'])->name('production');

});

 
Route::prefix('dashboard-oee')->name('oee.dashboard.')->middleware('auth')->group(function () {
    Route::get('/', function () {
        $data['page_title'] = 'Dashboard OEE ';
        return view('oee.dashboard.index', $data);
    })->name('index');
});

// Route::prefix('alarm-list')->name('oee.alarm-list.')->middleware('auth')->group(function () {
//     Route::get('/', function () {
//         $data['page_title'] = 'Alarm List ';
//         return view('oee.alarm-list.oee-alarm-list', $data);
//     })->name('index');
// });

Route::prefix('master-data')->name('master.data.')->middleware('auth')->group(function () {
    Route::get('/', function () {
        $data['page_title'] = 'Master Data ';
        return view('oee.machine.index', $data);
    })->name('index');
});
