<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Mrp\MrpMaterialController;
use App\Http\Controllers\Mrp\MrpPlaceController;
use App\Http\Controllers\Mrp\MrpUnitController;
use App\Http\Controllers\Mrp\MrpProblemController;
use App\Http\Controllers\Mrp\MrpCounterMeasureController;
use App\Http\Controllers\Mrp\MrpCustomerController;
use App\Http\Controllers\Mrp\MrpVehicleController;
use App\Http\Controllers\Mrp\MrpSupplierController;
use App\Http\Controllers\Mrp\MrpShiftController;
use App\Http\Controllers\Mrp\MrpEmployeeController;
use App\Http\Controllers\Mrp\MrpMachineController;
use App\Http\Controllers\Mrp\MrpProcessController;
use App\Http\Controllers\Mrp\MrpBomController;
use App\Http\Controllers\Mrp\MrpProductController;
use App\Http\Controllers\Mrp\MrpProductionController;
use App\Http\Controllers\Mrp\MrpPlanningProductionController;
use App\Http\Controllers\Mrp\MrpDeliveryPlanningController;
use App\Http\Controllers\Mrp\MrpDeliveryShipmentController;
use App\Http\Controllers\Mrp\MrpInventoryShipmentController;
use App\Http\Controllers\Mrp\MrpInventoryProductController;
use App\Http\Controllers\Mrp\MrpInventoryMaterialListController;
use App\Http\Controllers\Mrp\MrpStockDataInventoryController;
use App\Http\Controllers\Mrp\MrpInventoryMaterialIncomingController;
use App\Http\Controllers\Mrp\MrpInventoryMaterialOutController;
use App\Http\Controllers\Mrp\MrpInventoryProductListController;
use App\Http\Controllers\Mrp\MrpInventoryProductIncomingController;
use App\Http\Controllers\Mrp\MrpInventoryProductOutController;
use App\Http\Controllers\Mrp\MrpProductSortirController;
use App\Http\Controllers\Mrp\MrpReportProductionController;
use App\Http\Controllers\Mrp\MrpReportDeliveryController;
use App\Http\Controllers\Mrp\MrpReportInventoryMaterialController;
use App\Http\Controllers\Mrp\MrpReportInventoryProductController;
use App\Http\Controllers\Mrp\MrpInventoryMaterialAddStockController;
use App\Http\Controllers\Mrp\MrpReportWipController;
use App\Http\Controllers\Mrp\MrpReportBomController;
use App\Http\Controllers\Mrp\MrpReportSmcController;
use App\Http\Controllers\Mrp\MrpReportPlanningProductionController;
use App\Http\Controllers\Mrp\MrpReportInitialController;
use App\Http\Controllers\Mrp\MrpDashboardController;
use App\Http\Controllers\Mrp\MrpForecastController;
use App\Http\Controllers\Mrp\MrpImportController;
use App\Http\Controllers\Mrp\MrpMaterialSortirController;
use App\Models\Mrp\MrpMaterialSortir;
use App\Models\Mrp\MrpMaterialSortirNG;
use App\Models\Mrp\MrpMaterialSortirOK;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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



// Route::name('mrp.')->middleware('auth')->group(function () {
//     Route::get('/', [MrpDashboardController::class, 'index'])->name('dashboard');
//     Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
// });

// dashboard mrp
Route::prefix('dashboard')->name('mrp.dashboard-')->middleware('auth')->group(function () {
    Route::get('/dashboard-list', [MrpDashboardController::class, 'index'])->name('list');
    Route::post('/dashboard-list', [MrpDashboardController::class, 'index'])->name('list');
    Route::get('/filter-material', [MrpDashboardController::class, 'filterMaterial'])->name('filter-material');
    Route::get('/filter-product', [MrpDashboardController::class, 'filterProduct'])->name('filter-product');
    Route::get('/filter-card', [MrpDashboardController::class, 'filterCard'])->name('filter-card');
    Route::get('/filter-card-product', [MrpDashboardController::class, 'filterCardProduct'])->name('filter-cardproduct');
    Route::get('/detail-logistic', [MrpDashboardController::class, 'dashboardLogistic'])->name('logistic_list');
    Route::get('/detail-production', [MrpDashboardController::class, 'dashboardProduction'])->name('production_list');

    // Material
    Route::get('/detail-total_sortir', [MrpDashboardController::class, 'dashboardTotalSortir'])->name('total_sortir_list');
    Route::get('/detail-total_in', [MrpDashboardController::class, 'dashboardTotalIn'])->name('total_in_list');
    Route::get('/detail-total_ng', [MrpDashboardController::class, 'dashboardTotalNg'])->name('total_ng_list');

    // product
    Route::get('/detail-total_product', [MrpProductSortirController::class, 'dashboardTotalProduct'])->name('total_product_list');
    Route::get('/detail-total-in-product', [MrpProductSortirController::class, 'dashboardTotalInProduct'])->name('total_in_list');
    Route::get('/detail-total-ng-product', [MrpProductSortirController::class, 'dashboardTotalNgProduct'])->name('total_ng_list');
    
    Route::get('/stock-data-material', [MrpDashboardController::class, 'stockDataMaterial'])->name('stock-material');
    Route::post('/stock-data-product', [MrpDashboardController::class, 'stockDataProduct'])->name('stock-product');

});

// Dashboard Total Conveyor Logistic
    Route::prefix('conveyor_logistic')->name('mrp.conveyor-')->middleware('auth')->group(function () {
    Route::get('/conveyor_logistic-list', [MrpInventoryMaterialIncomingController::class, 'conveyorLogistic'])->name('conveyor_logistic');

});

// Dashboard Total Conveyor Production
    Route::prefix('conveyor_production')->name('mrp.conveyor-')->middleware('auth')->group(function () {
    Route::get('/conveyor_production-list', [MrpInventoryMaterialOutController::class, 'conveyorProduction'])->name('conveyor_production');

});

// Dashboard Total Sortir
    Route::prefix('total_sortir')->name('mrp.total-')->middleware('auth')->group(function () {
    Route::get('/total_sortir-list', [MrpMaterialSortirController::class, 'totalSortir'])->name('total_sortir');

});

// Dashboard Total OK Sortir
    Route::prefix('total_ok_sortir')->name('mrp.total-')->middleware('auth')->group(function () {
    Route::get('/total_ok_sortir-list', [MrpMaterialSortirController::class, 'totalOkSortir'])->name('total_ok_sortir');

});

// Dashboard Total NG Sortir
Route::prefix('total_ng_sortir')->name('mrp.total-')->middleware('auth')->group(function () {
    Route::get('/total_ng_sortir-list', [MrpMaterialSortirController::class, 'totalNgSortir'])->name('total_ng_sortir');

    
});


// Place
Route::prefix('place')->name('mrp.place-')->middleware('auth')->group(function () {
    Route::get('/place-list', [MrpPlaceController::class, 'index'])->name('list');
    Route::get('/place-create', [MrpPlaceController::class, 'create'])->name('create');
    Route::post('/place-store', [MrpPlaceController::class, 'store'])->name('store');
    Route::patch('/place-store/{id}', [MrpPlaceController::class, 'update'])->name('update');
    Route::get('/place-edit/{id}', [MrpPlaceController::class, 'edit'])->name('edit');
    Route::delete('/place-delete', [MrpPlaceController::class, 'destroy'])->name('delete');
    Route::post('/import-place', [MrpPlaceController::class, 'importPlace'])->name('place');
   
});

// unit
Route::prefix('unit')->name('mrp.unit-')->middleware('auth')->group(function () {
    Route::get('/unit-list', [MrpUnitController::class, 'index'])->name('list');
    Route::get('/unit-create', [MrpUnitController::class, 'create'])->name('create');
    Route::post('/unit-store', [MrpUnitController::class, 'store'])->name('store');
    Route::patch('/unit-store/{id}', [MrpUnitController::class, 'update'])->name('update');
    Route::get('/unit-edit/{id}', [MrpUnitController::class, 'edit'])->name('edit');
    Route::delete('/unit-delete', [MrpUnitController::class, 'destroy'])->name('delete');
    Route::post('/import-unit', [MrpUnitController::class, 'importUnit'])->name('unit');
});

// problem
Route::prefix('problem')->name('mrp.problem-')->middleware('auth')->group(function () {
    Route::get('/problem-list', [MrpProblemController::class, 'index'])->name('list');
    Route::get('/problem-create', [MrpProblemController::class, 'create'])->name('create');
    Route::post('/problem-store', [MrpProblemController::class, 'store'])->name('store');
    Route::patch('/problem-store/{id}', [MrpProblemController::class, 'update'])->name('update');
    Route::get('/problem-edit/{id}', [MrpProblemController::class, 'edit'])->name('edit');
    Route::delete('/problem-delete', [MrpProblemController::class, 'destroy'])->name('delete');
});

// counter measure
Route::prefix('counter_measure')->name('mrp.counter_measure-')->middleware('auth')->group(function () {
    Route::get('/counter_measure-list', [MrpCounterMeasureController::class, 'index'])->name('list');
    Route::get('/counter_measure-create', [MrpCounterMeasureController::class, 'create'])->name('create');
    Route::post('/counter_measure-store', [MrpCounterMeasureController::class, 'store'])->name('store');
    Route::patch('/counter_measure-store/{id}', [MrpCounterMeasureController::class, 'update'])->name('update');
    Route::get('/counter_measure-edit/{id}', [MrpCounterMeasureController::class, 'edit'])->name('edit');
    Route::delete('/counter_measure-delete', [MrpCounterMeasureController::class, 'destroy'])->name('delete');
});

// customer
Route::prefix('customer')->name('mrp.customer-')->middleware('auth')->group(function () {
    Route::get('/customer-list', [MrpCustomerController::class, 'index'])->name('list');
    Route::get('/customer-create', [MrpCustomerController::class, 'create'])->name('create');
    Route::post('/customer-store', [MrpCustomerController::class, 'store'])->name('store');
    Route::patch('/customer-store/{id}', [MrpCustomerController::class, 'update'])->name('update');
    Route::get('/customer-edit/{id}', [MrpCustomerController::class, 'edit'])->name('edit');
    Route::delete('/customer-delete', [MrpCustomerController::class, 'destroy'])->name('delete');
    Route::get('/customer-show/detail/{id}', [MrpCustomerController::class, 'show'])->name('show');
   
});

// customer
Route::prefix('supplier')->name('mrp.supplier-')->middleware('auth')->group(function () {
    Route::get('/supplier-list', [MrpSupplierController::class, 'index'])->name('list');
    Route::get('/supplier-create', [MrpSupplierController::class, 'create'])->name('create');
    Route::post('/supplier-store', [MrpSupplierController::class, 'store'])->name('store');
    Route::patch('/supplier-store/{id}', [MrpSupplierController::class, 'update'])->name('update');
    Route::get('/supplier-edit/{id}', [MrpSupplierController::class, 'edit'])->name('edit');
    Route::delete('/supplier-delete', [MrpSupplierController::class, 'destroy'])->name('delete');
});

// Vehicle
Route::prefix('vehicle')->name('mrp.vehicle-')->middleware('auth')->group(function () {
    Route::get('/vehicle-list', [MrpVehicleController::class, 'index'])->name('list');
    Route::get('/vehicle-create', [MrpVehicleController::class, 'create'])->name('create');
    Route::post('/vehicle-store', [MrpVehicleController::class, 'store'])->name('store');
    Route::patch('/vehicle-store/{id}', [MrpVehicleController::class, 'update'])->name('update');
    Route::get('/vehicle-edit/{id}', [MrpVehicleController::class, 'edit'])->name('edit');
    Route::delete('/vehicle-delete', [MrpVehicleController::class, 'destroy'])->name('delete');
});

// shift
Route::prefix('shift')->name('mrp.shift-')->middleware('auth')->group(function () {
    Route::get('/shift-list', [MrpShiftController::class, 'index'])->name('list');
    Route::get('/shift-create', [MrpShiftController::class, 'create'])->name('create');
    Route::post('/shift-store', [MrpShiftController::class, 'store'])->name('store');
    Route::patch('/shift-store/{id}', [MrpShiftController::class, 'update'])->name('update');
    Route::get('/shift-edit/{id}', [MrpShiftController::class, 'edit'])->name('edit');
    Route::delete('/shift-delete', [MrpShiftController::class, 'destroy'])->name('delete');
});

// employee
Route::prefix('employee')->name('mrp.employee-')->middleware('auth')->group(function () {
    Route::get('/employee-list', [MrpEmployeeController::class, 'index'])->name('list');
    Route::get('/employee-create', [MrpEmployeeController::class, 'create'])->name('create');
    Route::post('/employee-store', [MrpEmployeeController::class, 'store'])->name('store');
    Route::patch('/employee-store/{id}', [MrpEmployeeController::class, 'update'])->name('update');
    Route::get('/employee-edit/{id}', [MrpEmployeeController::class, 'edit'])->name('edit');
    Route::delete('/employee-delete', [MrpEmployeeController::class, 'destroy'])->name('delete');
    Route::post('/import-employee', [MrpEmployeeController::class, 'importEmployee'])->name('employee');
});

// machine
Route::prefix('machine')->name('mrp.machine-')->middleware('auth')->group(function () {
    Route::get('/machine-list', [MrpMachineController::class, 'index'])->name('list');
    Route::get('/machine-create', [MrpMachineController::class, 'create'])->name('create');
    Route::post('/machine-store', [MrpMachineController::class, 'store'])->name('store');
    Route::patch('/machine-store/{id}', [MrpMachineController::class, 'update'])->name('update');
    Route::get('/machine-edit/{id}', [MrpMachineController::class, 'edit'])->name('edit');
    Route::delete('/machine-delete', [MrpMachineController::class, 'destroy'])->name('delete');
});

// process
Route::prefix('process')->name('mrp.process-')->middleware('auth')->group(function () {
    Route::get('/process-list', [MrpProcessController::class, 'index'])->name('list');
    Route::get('/process-create', [MrpProcessController::class, 'create'])->name('create');
    Route::post('/process-store', [MrpProcessController::class, 'store'])->name('store');
    Route::patch('/process-store/{id}', [MrpProcessController::class, 'update'])->name('update');
    Route::get('/process-edit/{id}', [MrpProcessController::class, 'edit'])->name('edit');
    Route::delete('/process-delete', [MrpProcessController::class, 'destroy'])->name('delete');
    Route::get('/process-show/detail/{id}', [MrpProcessController::class, 'show'])->name('show');
    Route::post('/process-name', [MrpProcessController::class, 'ajaxProcess'])->name('ajax');

});

// material
Route::prefix('material')->name('mrp.material-')->middleware('auth')->group(function () {
    Route::get('/material-list', [MrpMaterialController::class, 'index'])->name('list');
    Route::get('/report-list', [MrpMaterialController::class, 'report'])->name('report');
    Route::get('/material-create', [MrpMaterialController::class, 'create'])->name('create');
    Route::post('/material-store', [MrpMaterialController::class, 'store'])->name('store');
    Route::patch('/material-store/{id}', [MrpMaterialController::class, 'update'])->name('update');
    Route::get('/material-edit/{id}', [MrpMaterialController::class, 'edit'])->name('edit');
    Route::delete('/material-delete', [MrpMaterialController::class, 'destroy'])->name('delete');
});

// product
Route::prefix('product')->name('mrp.product-')->middleware('auth')->group(function () {
    Route::get('/product-list', [MrpProductController::class, 'index'])->name('list');
    Route::get('/product-create', [MrpProductController::class, 'create'])->name('create');
    Route::post('/product-store', [MrpProductController::class, 'store'])->name('store');
    Route::patch('/product-store/{id}', [MrpProductController::class, 'update'])->name('update');
    Route::get('/product-edit/{id}', [MrpProductController::class, 'edit'])->name('edit');
    Route::delete('/product-delete', [MrpProductController::class, 'destroy'])->name('delete');
    
    
});

// bom
Route::prefix('bom')->name('mrp.bom-')->middleware('auth')->group(function () {
    Route::get('/bom-list', [MrpBomController::class, 'index'])->name('list');
    Route::get('/bom-report', [MrpBomController::class, 'report'])->name('report');
    Route::get('/bom-create', [MrpBomController::class, 'create'])->name('create');
    Route::post('/bom-store', [MrpBomController::class, 'store'])->name('store');
    Route::patch('/bom-store/{id}', [MrpBomController::class, 'update'])->name('update');
    Route::get('/bom-show/detail/{id}', [MrpBomController::class, 'show'])->name('show');
    Route::get('/bom-edit/{id}', [MrpBomController::class, 'edit'])->name('edit');
    Route::delete('/bom-delete', [MrpBomController::class, 'destroy'])->name('delete');
    // Api Get Material
    Route::get('/api/{id}', [MrpBomController::class, 'getMaterialById']);
});

// planning
Route::prefix('planning')->name('mrp.production.planning-')->middleware('auth')->group(function () {
    Route::get('/planning-list', [MrpPlanningProductionController::class, 'index'])->name('list');
    Route::get('/planning-create', [MrpPlanningProductionController::class, 'create'])->name('create');
    Route::post('/planning-store', [MrpPlanningProductionController::class, 'store'])->name('store');
    Route::put('/planning-store/{id}', [MrpPlanningProductionController::class, 'update'])->name('update');
    Route::get('/planning-edit/{id}', [MrpPlanningProductionController::class, 'edit'])->name('edit');
    Route::delete('/planning-delete', [MrpPlanningProductionController::class, 'destroy'])->name('delete');
    Route::get('/planning-show/detail/{id}', [MrpPlanningProductionController::class, 'show'])->name('show');
    Route::get('/planning-show-product/detail/{id}', [MrpPlanningProductionController::class, 'showProduct'])->name('showProduct');
    Route::get('/planning-show-customer/detail/{id}', [MrpPlanningProductionController::class, 'showCustomer'])->name('showCustomer');
    // Api get planing
    Route::get('/api/{id}', [MrpPlanningProductionController::class, 'getProductionPlanningById']);
    // Get Process Name Select Option Ajax
    Route::post('/process-name', [MrpPlanningProductionController::class, 'ajaxProcess'])->name('ajax');
    // Get Process Name Select Option Ajax
    Route::post('/bom-name', [MrpPlanningProductionController::class, 'ajaxBom'])->name('ajax_bom');

    // Get BOM Name Select Option Ajax
    Route::post('/get-bom-name-product', [MrpPlanningProductionController::class, 'ajaxProductBom'])->name('ajaxProductBom');

    // Get Part Number Select Option Ajax
    Route::get('/get-part-number-product', [MrpPlanningProductionController::class, 'ajaxProductPartNumber'])->name('ajaxProductPartNumber');

    // Api change confirm column
    Route::post('/api/confirm/{id}', [MrpPlanningProductionController::class, 'changeConfirm']);
});

// production
Route::prefix('production')->name('mrp.production.production-')->middleware('auth')->group(function () {
    Route::get('/production-list', [MrpProductionController::class, 'index'])->name('list');
    Route::get('/production-create', [MrpProductionController::class, 'create'])->name('create');
    Route::post('/production-store', [MrpProductionController::class, 'store'])->name('store');
    Route::patch('/production-store/{id}', [MrpProductionController::class, 'update'])->name('update');
    Route::get('/production-edit/{id}', [MrpProductionController::class, 'edit'])->name('edit');
    Route::get('/production-entry/{id}', [MrpProductionController::class, 'entry'])->name('entry');
    Route::delete('/production-delete', [MrpProductionController::class, 'destroy'])->name('delete');

    Route::get('/production-detail/{id}', [MrpProductionController::class, 'detail'])->name('detail');
    Route::post('/production-detail/wip-save/{id}', [MrpProductionController::class, 'wipSave'])->name('wip-save');

    
    // Get BOM Name Select Option Ajax
    Route::post('/get-bom-name', [MrpProductionController::class, 'ajaxBom'])->name('ajaxBom');

    // Get Product Name Select Option Ajax
    Route::post('/get-product-name', [MrpProductionController::class, 'ajaxProduct'])->name('ajaxProduct');

    // Get Quantity Name Select Option Ajax
    Route::post('/get-quantity-name', [MrpProductionController::class, 'ajaxQuantity'])->name('ajaxQuantity');

    Route::get('/api/process/{id}', [MrpProductionController::class, 'getProductionProcessById']);
});


// delivery planning
Route::prefix('delivery_planning')->name('mrp.delivery.delivery_planning.delivery_planning-')->middleware('auth')->group(function () {
    Route::get('/delivery_planning-list', [MrpDeliveryPlanningController::class, 'index'])->name('list');
    Route::get('/delivery_planning-create', [MrpDeliveryPlanningController::class, 'create'])->name('create');
    Route::post('/delivery_planning-store', [MrpDeliveryPlanningController::class, 'store'])->name('store');
    Route::patch('/delivery_planning-store/{id}', [MrpDeliveryPlanningController::class, 'update'])->name('update');
    Route::get('/delivery_planning-edit/{id}', [MrpDeliveryPlanningController::class, 'edit'])->name('edit');
    Route::delete('/delivery_planning-delete', [MrpDeliveryPlanningController::class, 'destroy'])->name('delete');
});

// delivery Report
Route::prefix('report_delivery')->name('mrp.report.report_delivery-')->middleware('auth')->group(function () {
    Route::get('/report_delivery-list', [MrpReportDeliveryController::class, 'index'])->name('list');
    Route::get('/report_delivery-create', [MrpReportDeliveryController::class, 'create'])->name('create');
    Route::post('/report_delivery-store', [MrpReportDeliveryController::class, 'store'])->name('store');
    Route::patch('/report_delivery-store/{id}', [MrpReportDeliveryController::class, 'update'])->name('update');
    Route::get('/report_delivery-edit/{id}', [MrpReportDeliveryController::class, 'edit'])->name('edit');
    Route::delete('/report_delivery-delete', [MrpReportDeliveryController::class, 'destroy'])->name('delete');
});

// shipment
Route::prefix('delivery_shipment')->name('mrp.delivery.delivery_shipment.delivery_shipment-')->middleware('auth')->group(function () {
    Route::get('/delivery_shipment-list', [MrpDeliveryShipmentController::class, 'index'])->name('list');
    Route::get('/delivery_shipment-po', [MrpDeliveryShipmentController::class, 'po'])->name('po');
    Route::get('/delivery_shipment-create', [MrpDeliveryShipmentController::class, 'create'])->name('create');
    Route::post('/delivery_shipment-store', [MrpDeliveryShipmentController::class, 'store'])->name('store');
    Route::patch('/delivery_shipment-store/{id}', [MrpDeliveryShipmentController::class, 'update'])->name('update');
    Route::get('/delivery_shipment-edit/{id}', [MrpDeliveryShipmentController::class, 'edit'])->name('edit');
    Route::delete('/delivery_shipment-delete', [MrpDeliveryShipmentController::class, 'destroy'])->name('delete');
    Route::delete('/inventory_shipment-delete', [MrpDeliveryShipmentController::class, 'inventoryShipmentDestroy'])->name('inventoryShipmentDelete');

});

// inventory product
// Route::prefix('inventory_product')->name('mrp.inventory_product-')->middleware('auth')->group(function () {
//     Route::get('/inventory_product-list', [MrpInventoryProductController::class, 'index'])->name('list');
//     Route::get('/inventory_product-create', [MrpInventoryProductController::class, 'create'])->name('create');
//     Route::post('/inventory_product-store', [MrpInventoryProductController::class, 'store'])->name('store');
//     Route::patch('/inventory_product-store/{id}', [MrpInventoryProductController::class, 'update'])->name('update');
//     Route::get('/inventory_product-edit/{id}', [MrpInventoryProductController::class, 'edit'])->name('edit');
//     Route::delete('/inventory_product-delete', [MrpInventoryProductController::class, 'destroy'])->name('delete');
// });

// inventory material list
// Route::prefix('inventory_material')->name('mrp.inventory_material-')->middleware('auth')->group(function () {
//     Route::get('/inventory_material-list', [MrpInventoryMaterialListController::class, 'index'])->name('list');
//     Route::get('/inventory_material-create', [MrpInventoryMaterialListController::class, 'create'])->name('create');
//     Route::post('/inventory_material-store', [MrpInventoryMaterialListController::class, 'store'])->name('store');
//     Route::patch('/inventory_material-store/{id}', [MrpInventoryMaterialListController::class, 'update'])->name('update');
//     Route::get('/inventory_material-edit/{id}', [MrpInventoryMaterialListController::class, 'edit'])->name('edit');
//     Route::delete('/inventory_material-delete', [MrpInventoryMaterialListController::class, 'destroy'])->name('delete');

// });
Route::prefix('inventory_material')->name('mrp.inventory_material-')->middleware('auth')->group(function () {
    Route::get('/inventory_material-list', [MrpInventoryMaterialListController::class, 'index'])->name('list');
    Route::get('/inventory_material-create', [MrpInventoryMaterialListController::class, 'create'])->name('create');
    Route::post('/inventory_material-store', [MrpInventoryMaterialListController::class, 'store'])->name('store');
    Route::patch('/inventory_material-store/{id}', [MrpInventoryMaterialListController::class, 'update'])->name('update');
    Route::get('/inventory_material-edit/{id}', [MrpInventoryMaterialListController::class, 'edit'])->name('edit');
    Route::delete('/inventory_material-delete', [MrpInventoryMaterialListController::class, 'destroy'])->name('delete');
    Route::get('/stock-data-material', [MrpStockDataInventoryController::class, 'stockDataMaterial'])->name('stock-material');
    Route::post('/stock-data-material', [MrpStockDataInventoryController::class, 'stockDataMaterial'])->name('stock-material');

    Route::get('/api/{id}', [MrpInventoryMaterialListController::class, 'getInventoryMaterialListById']);

});

// inventory stock in material
Route::prefix('material-incoming')->name('mrp.material-incoming-')->middleware('auth')->group(function () {
    Route::get('/material-incoming-list', [MrpInventoryMaterialIncomingController::class, 'index'])->name('list');
    Route::get('/material-incoming-create', [MrpInventoryMaterialIncomingController::class, 'create'])->name('create');
    Route::post('/material-incoming-store', [MrpInventoryMaterialIncomingController::class, 'store'])->name('store');
    Route::patch('/material-incoming-store/{id}', [MrpInventoryMaterialIncomingController::class, 'update'])->name('update');
    Route::get('/material-incoming-edit/{id}', [MrpInventoryMaterialIncomingController::class, 'edit'])->name('edit');
    Route::delete('/material-incoming-delete', [MrpInventoryMaterialIncomingController::class, 'destroy'])->name('delete');
    
    Route::get('/api/{id}', [MrpInventoryMaterialIncomingController::class, 'getInventoryMaterialListById']);
});

// inventory stock out material
Route::prefix('material-out')->name('mrp.material-out-')->middleware('auth')->group(function () {
    Route::get('/material-out-list', [MrpInventoryMaterialOutController::class, 'index'])->name('list');
    Route::get('/material-out-create', [MrpInventoryMaterialOutController::class, 'create'])->name('create');
    Route::post('/material-out-store', [MrpInventoryMaterialOutController::class, 'store'])->name('store');
    Route::patch('/material-out-store/{id}', [MrpInventoryMaterialOutController::class, 'update'])->name('update');
    Route::get('/material-out-edit/{id}', [MrpInventoryMaterialOutController::class, 'edit'])->name('edit');
    Route::delete('/material-out-delete', [MrpInventoryMaterialOutController::class, 'destroy'])->name('delete');
    Route::get('/material-out-sortir-list', [MrpInventoryMaterialOutController::class, 'indexSortir'])->name('list-out-sortir');
    Route::get('/api/{id}', [MrpInventoryMaterialOutController::class, 'getInventoryMaterialListById']);

});

// material sortir
Route::prefix('material-sortir')->name('mrp.material-sortir-')->middleware('auth')->group(function () {
    Route::get('/material-sortir-list', [MrpMaterialSortirController::class, 'index'])->name('list');
    Route::get('/material-sortir-create', [MrpMaterialSortirController::class, 'create'])->name('create');
    Route::post('/material-sortir-store', [MrpMaterialSortirController::class, 'store'])->name('store');
    Route::patch('/material-sortir-store/{id}', [MrpMaterialSortirController::class, 'update'])->name('update');
    Route::get('/material-sortir-edit/{id}', [MrpMaterialSortirController::class, 'edit'])->name('edit');
    Route::delete('/material-sortir-delete', [MrpMaterialSortirController::class, 'destroy'])->name('delete');
    Route::get('/material-sortir-sortir-list', [MrpMaterialSortirController::class, 'indexSortir'])->name('list-out-sortir');
    Route::get('/api/{id}', [MrpMaterialSortirController::class, 'getInventoryMaterialListById']);
    
    Route::get('/material-sortir-ok-create', [MrpMaterialSortirController::class, 'createSortirOK'])->name('create-sortir-ok');
    Route::post('/material-sortir-ok-store', [MrpMaterialSortirController::class, 'storeSortirOK'])->name('store-sortir-ok');
    Route::get('/material-sortir-ng-create', [MrpMaterialSortirController::class, 'createSortingNG'])->name('create-sortir-ng');
    Route::post('/material-sortir-ng-store', [MrpMaterialSortirController::class, 'storeSortirNG'])->name('store-sortir-ng');
    Route::get('/material-sortir-ok-list', [MrpMaterialSortirController::class, 'indexSortirOK'])->name('list-sortir-ok');
    Route::get('/material-sortir-ng-list', [MrpMaterialSortirController::class, 'indexSortirNG'])->name('list-sortir-ng');
    Route::delete('/material-sortir-ok-delete', [MrpMaterialSortirController::class, 'destroySortirOK'])->name('delete-sortir-ok');
    Route::delete('/material-sortir-ng-delete', [MrpMaterialSortirController::class, 'destroySortirNG'])->name('delete-sortir-ng');
    Route::patch('/material-sortir-ok-store/{id}', [MrpMaterialSortirController::class, 'updateSortirOK'])->name('update-sortir-ok');
    Route::get('/material-sortir-ok-edit/{id}', [MrpMaterialSortirController::class, 'editSortirOK'])->name('edit-sortir-ok');
    Route::patch('/material-sortir-ng-store/{id}', [MrpMaterialSortirController::class, 'updateSortirNG'])->name('update-sortir-ng');
    Route::get('/material-sortir-ng-edit/{id}', [MrpMaterialSortirController::class, 'editSortirNG'])->name('edit-sortir-ng');

});

// product sortir
Route::prefix('product-sortir')->name('mrp.product-sortir-')->middleware('auth')->group(function () {
    Route::get('/product-sortir-list', [MrpProductSortirController::class, 'index'])->name('list');
    Route::get('/product-sortir-create', [MrpProductSortirController::class, 'create'])->name('create');
    Route::post('/product-sortir-store', [MrpProductSortirController::class, 'store'])->name('store');
    Route::patch('/product-sortir-store/{id}', [MrpProductSortirController::class, 'update'])->name('update');
    Route::patch('/product-sortir-store/{id}', [MrpProductSortirController::class, 'update'])->name('update');
    Route::get('/product-sortir-edit/{id}', [MrpProductSortirController::class, 'edit'])->name('edit');
    Route::delete('/product-sortir-delete', [MrpProductSortirController::class, 'destroy'])->name('delete');
    Route::get('/product-sortir-sortir-list', [MrpProductSortirController::class, 'indexSortir'])->name('list-out-sortir');

    Route::get('/product-sortir-ok-list', [MrpProductSortirController::class, 'indexSortirOK'])->name('list-sortir-ok');
    Route::get('/product-sortir-ok-create', [MrpProductSortirController::class, 'createSortirOK'])->name('create-sortir-ok');
    Route::post('/product-sortir-ok-store', [MrpProductSortirController::class, 'storeSortirOK'])->name('store-sortir-ok');
    Route::patch('/product-sortir-ok-store/{id}', [MrpProductSortirController::class, 'updateSortirOK'])->name('update-sortir-ok');
    Route::get('/product-sortir-ok-edit/{id}', [MrpProductSortirController::class, 'editSortirOK'])->name('edit-sortir-ok');
    Route::delete('/product-sortir-ok-delete', [MrpProductSortirController::class, 'destroySortirOK'])->name('delete-sortir-ok');

    Route::get('/product-sortir-ng-list', [MrpProductSortirController::class, 'indexSortirNG'])->name('list-sortir-ng');
    Route::get('/product-sortir-ng-create', [MrpProductSortirController::class, 'createSortirNG'])->name('create-sortir-ng');
    Route::post('/product-sortir-ng-store', [MrpProductSortirController::class, 'storeSortirNG'])->name('store-sortir-ng');
    Route::patch('/product-sortir-ng-store/{id}', [MrpProductSortirController::class, 'updateSortirNG'])->name('update-sortir-ng');
    Route::get('/product-sortir-ng-edit/{id}', [MrpProductSortirController::class, 'editSortirNG'])->name('edit-sortir-ng');
    Route::delete('/product-sortir-ng-delete', [MrpProductSortirController::class, 'destroySortirNG'])->name('delete-sortir-ng');

    // Route::get('/product-sortir-ng-create', [MrpProductSortirController::class, 'createSortingNG'])->name('create-sortir-ng');
    // Route::post('/product-sortir-ng-store', [MrpProductSortirController::class, 'storeSortirNG'])->name('store-sortir-ng');
    Route::get('/api/{id}', [MrpProductSortirController::class, 'getInventoryProductListById']);


});


// inventory product list
Route::prefix('inventory_product')->name('mrp.inventory_product-')->middleware('auth')->group(function () {
    Route::get('/inventory_product-list', [MrpInventoryProductListController::class, 'index'])->name('list');
    Route::get('/inventory_product-create', [MrpInventoryProductListController::class, 'create'])->name('create');
    Route::post('/inventory_product-store', [MrpInventoryProductListController::class, 'store'])->name('store');
    Route::patch('/inventory_product-update/{id}', [MrpInventoryProductListController::class, 'update'])->name('update');
    Route::get('/inventory_product-edit/{id}', [MrpInventoryProductListController::class, 'edit'])->name('edit');
    Route::delete('/inventory_product-delete', [MrpInventoryProductListController::class, 'destroy'])->name('delete');
    Route::get('/stock-data-product', [MrpStockDataInventoryController::class, 'stockDataProduct'])->name('stock-product');
    Route::post('/stock-data-product', [MrpStockDataInventoryController::class, 'stockDataProduct'])->name('stock-product');

});

// inventory stock in product
Route::prefix('product-incoming')->name('mrp.product-incoming-')->middleware('auth')->group(function () {
    Route::get('/product-incoming-list', [MrpInventoryProductIncomingController::class, 'index'])->name('list');
    Route::get('/product-incoming-create', [MrpInventoryProductIncomingController::class, 'create'])->name('create');
    Route::post('/product-incoming-store', [MrpInventoryProductIncomingController::class, 'store'])->name('store');
    Route::patch('/product-incoming-store/{id}', [MrpInventoryProductIncomingController::class, 'update'])->name('update');
    Route::get('/product-incoming-edit/{id}', [MrpInventoryProductIncomingController::class, 'edit'])->name('edit');
    Route::delete('/product-incoming-delete', [MrpInventoryProductIncomingController::class, 'destroy'])->name('delete');

    Route::get('/api/{id}', [MrpInventoryProductIncomingController::class, 'getInventoryProductListById']);
    // Route::get('/api/product/{id}', [MrpInventoryProductIncomingController::class, 'getProductionQty']);
    
});

// inventory stock out product
Route::prefix('product-out')->name('mrp.product-out-')->middleware('auth')->group(function () {
    Route::get('/product-out-list', [MrpInventoryProductOutController::class, 'index'])->name('list');
    Route::get('/product-out-show/detail/{id}', [MrpInventoryProductOutController::class, 'show'])->name('show');
    Route::get('/product-out-sortir', [MrpInventoryProductOutController::class, 'indexSortir'])->name('list-out-sortir');
    Route::get('/product-out-create', [MrpInventoryProductOutController::class, 'create'])->name('create');
    Route::post('/product-out-store', [MrpInventoryProductOutController::class, 'store'])->name('store');
    Route::patch('/product-out-store/{id}', [MrpInventoryProductOutController::class, 'update'])->name('update');
    Route::get('/product-out-edit/{id}', [MrpInventoryProductOutController::class, 'edit'])->name('edit');
    Route::delete('/product-out-delete', [MrpInventoryProductOutController::class, 'destroy'])->name('delete');
    Route::get('/api/{id}', [MrpInventoryProductOutController::class, 'getInventoryProductListById']);

    
});

// Report planning
Route::prefix('report_planning')->name('mrp.report_planning-')->middleware('auth')->group(function () {
    Route::get('/report_planning-list', [MrpReportPlanningProductionController::class, 'index'])->name('list');
    Route::get('/report-planning-detail/{id}', [MrpReportPlanningProductionController::class, 'detail'])->name('detail');
    Route::post('/report_planning-list', [MrpReportPlanningProductionController::class, 'index'])->name('listt');
    Route::get('/report_planning-export, {start_date}', [MrpReportPlanningProductionController::class, 'export'])->name('export');
    Route::get('/report_planning-pdf', [MrpReportPlanningProductionController::class, 'export_pdf'])->name('export_pdf');
});

// Report Initial 
Route::prefix('report_initial')->name('mrp.report_initial-')->middleware('auth')->group(function () {
    Route::get('/report_initial-list', [MrpReportInitialController::class, 'index'])->name('list');
    Route::post('/report_initial-list', [MrpReportInitialController::class, 'index'])->name('list');
    Route::get('/report_initial-export, {start_date}', [MrpReportInitialController::class, 'export'])->name('export');
    Route::get('/report_initial-pdf', [MrpReportInitialController::class, 'export_pdf'])->name('export_pdf');
});

// Report production
Route::prefix('report')->name('mrp.report.report-')->middleware('auth')->group(function () {
    Route::get('/report-list', [MrpReportProductionController::class, 'index'])->name('list');
    Route::get('/report-production-detail/{id}', [MrpReportProductionController::class, 'detail'])->name('detail');
    Route::post('/report-list', [MrpReportProductionController::class, 'index'])->name('list');
    Route::get('/report-export, {start_date}', [MrpReportProductionController::class, 'export'])->name('export');
    Route::get('/report-pdf', [MrpReportProductionController::class, 'export_pdf'])->name('export_pdf');
});

// inventory material Report
Route::prefix('report_inventory_material')->name('mrp.report_inventory_material-')->middleware('auth')->group(function () {
    Route::get('/report_inventory_material-list', [MrpReportInventoryMaterialController::class, 'index'])->name('list');
    Route::post('/report_inventory_material-list', [MrpReportInventoryMaterialController::class, 'index'])->name('list');
    Route::get('/report_inventory_detail/{id}', [MrpReportInventoryMaterialController::class, 'detail'])->name('detail');

});

// inventory product Report
Route::prefix('report_inventory_product')->name('mrp.report_inventory_product-')->middleware('auth')->group(function () {
    Route::get('/report_inventory_product-list', [MrpReportInventoryProductController::class, 'index'])->name('list');
    Route::post('/report_inventory_product-list', [MrpReportInventoryProductController::class, 'index'])->name('list');
});

//  WIP Report
Route::prefix('report_wip')->name('mrp.report.report_wip-')->middleware('auth')->group(function () {
    Route::get('/report_wip-list', [MrpReportWipController::class, 'index'])->name('list');
    Route::post('/report_wip-list', [MrpReportWipController::class, 'index'])->name('list');
    Route::get('/report_wip-export', [MrpReportWipController::class, 'export_excel'])->name('export');
    // Route::get('/report-export', [MrpReportWipController::class, 'show_excel'])->name('show');
});

//  Bom Report
Route::prefix('report_bom')->name('mrp.report.report_bom-')->middleware('auth')->group(function () {
    Route::get('/report_bom-list', [MrpReportBomController::class, 'index'])->name('list');
    Route::post('/report_bom-list', [MrpReportBomController::class, 'index'])->name('list');
    Route::get('/report_bom-export', [MrpReportBomController::class, 'export_excel'])->name('export');
    Route::get('/report_bom-pdf', [MrpReportBomController::class, 'export_pdf'])->name('export_pdf');

});

// Summary Forecast Customer
Route::prefix('report_smc')->name('mrp.report_smc-')->group(function () {
    Route::get('/report_smc-list', [MrpReportSmcController::class, 'index'])->name('list');
    Route::post('/report_smc-list', [MrpReportSmcController::class, 'index'])->name('list');
    Route::get('/report_smc-excel/{start_date}/{end_date}', [MrpReportSmcController::class, 'export_excel'])->name('excel');
});

// forecast
Route::prefix('forecast')->name('mrp.forecast-')->middleware('auth')->group(function () {
    Route::get('/forecast-list', [MrpForecastController::class, 'index'])->name('list');
    Route::get('/forecast-create', [MrpForecastController::class, 'create'])->name('create');
    Route::post('/forecast-store', [MrpForecastController::class, 'store'])->name('store');
    Route::patch('/forecast-store/{id}', [MrpForecastController::class, 'update'])->name('update');
    Route::get('/forecast-edit/{id}', [MrpForecastController::class, 'edit'])->name('edit');
    Route::delete('/forecast-delete', [MrpForecastController::class, 'destroy'])->name('delete');
    Route::get('/forecast-show/detail/{id}', [MrpForecastController::class, 'show'])->name('show');

});

// // report delivery
// Route::prefix('report_delivery')->name('mrp.delivery.report_delivery-')->middleware('auth')->group(function () {
//     Route::get('/report_delivery-list', [MrpReportDeliveryController::class, 'index'])->name('list');

// });

// forecast
Route::prefix('forecast')->name('mrp.forecast-')->middleware('auth')->group(function () {
    Route::get('forecast', function () {
        $data['page_title'] = 'Forecast';
        return view('mrp.forecasts.index', $data);
    })->name('index');
});

// master data
Route::prefix('master-data')->name('mrp.master-data-')->middleware('auth')->group(function () {
    Route::get('master-data', function () {
        $data['page_title'] = 'Master Data';
        return view('mrp.master-data.index', $data);
    })->name('index');
});

// production
Route::prefix('production')->name('mrp.production-')->middleware('auth')->group(function () {
    Route::get('production', function () {
        $data['page_title'] = 'Production';
        return view('mrp.production.index', $data);
    })->name('index');
});

// delivery
Route::prefix('delivery')->name('mrp.delivery-')->middleware('auth')->group(function () {
    Route::get('delivery', function () {
        $data['page_title'] = 'Delivery';
        return view('mrp.delivery.index', $data);
    })->name('index');
});

//inventory 
Route::prefix('inventory')->name('mrp.inventory-')->middleware('auth')->group(function () {
    Route::get('inventory-index', function () {
        $data['page_title'] = 'Inventory Index';
        return view('mrp.inventories.index', $data);
    })->name('index');
});

//inventory material
Route::prefix('inventory-material')->name('mrp.inventory-material-')->middleware('auth')->group(function () {
    Route::get('inventory-material', function () {
        $data['page_title'] = 'Inventory Material';
        return view('mrp.inventories.materials.list-material.index', $data);
    })->name('index');
});

Route::prefix('material-out')->name('mrp.inventory-material-out-')->middleware('auth')->group(function () {
    Route::get('inventory-material-out', function () {
        $data['page_title'] = 'Inventory Material Out';
        return view('mrp.inventories.materials.stock-out.index', $data);
    })->name('index');
});

Route::prefix('product-out')->name('mrp.inventory-product-out-')->middleware('auth')->group(function () {
    Route::get('inventory-product-out', function () {
        $data['page_title'] = 'Inventory Product Out';
        return view('mrp.inventories.products.stock-out.index', $data);
    })->name('index');
});

//inventory product
Route::prefix('inventory-product')->name('mrp.inventory-product-')->middleware('auth')->group(function () {
    Route::get('inventory-product', function () {
        $data['page_title'] = 'Inventory Product';
        return view('mrp.inventories.products.list-product.index', $data);
    })->name('index');
});

//report inventory material
Route::prefix('report-inventory')->name('mrp.report-inventory-')->middleware('auth')->group(function () {
    Route::get('report-inventory', function () {
        $data['page_title'] = 'Report Inventory';
        return view('mrp.inventories.reports.index', $data);
    })->name('index');
});

Route::prefix('reports')->name('mrp.reports-')->middleware('auth')->group(function () {
    Route::get('reports', function () {
        $data['page_title'] = 'Report ';
        return view('mrp.reports.index', $data);
    })->name('index');
});

Route::prefix('dashboard-oee')->name('oee.dashboard-')->middleware('auth')->group(function () {
    Route::get('dashboard-oee', function () {
        $data['page_title'] = 'Dashboard OEE ';
        return view('oee.dashboard.index', $data);
    })->name('index');
});






// Route::prefix('material')->name('mrp.material-')->middleware('auth')->group(function () {
//     Route::get('/', [MrpMaterialController::class, 'index'])->name('list');
// });




// Route::get('master-data', function () {
//     $data['page_title'] = 'Master Data';
//     return view('master-data.index', $data);
// })->name('master-data.index');

    // Route::get('/role-list', [RoleController::class, 'index'])->name('role-list');
    // Route::get('/role-create', [RoleController::class, 'create'])->name('role-create');
    // Route::get('/role-edit/{id}', [RoleController::class, 'edit'])->name('role-edit');
    // Route::post('/role-store', [RoleController::class, 'store'])->name('role-store');
    // Route::delete('/role-delete', [RoleController::class, 'delete'])->name('role-delete');
    // Route::patch('/role-store/{id}', [RoleController::class, 'update'])->name('role-update');
    
    // Route::get('/permission-list', [PermissionController::class, 'index'])->name('permission-list');
    // Route::get('/permission-create', [PermissionController::class, 'create'])->name('permission-create');
    // Route::get('/permission-edit/{id}', [PermissionController::class, 'edit'])->name('permission-edit');
    // Route::post('/permission-store', [PermissionController::class, 'store'])->name('permission-store');
    // Route::patch('/permission-store/{id}', [PermissionController::class, 'update'])->name('permission-update');
    // Route::delete('/permission-delete', [PermissionController::class, 'delete'])->name('permission-delete');

    Route::prefix('import')->name('import.')->group(function () {
        Route::post('place', [MrpImportController::class, 'importFilePlace'])->name('place');
        Route::post('employee', [MrpImportController::class, 'importFileEmployee'])->name('employee');
        Route::post('customer', [MrpImportController::class, 'importFileCustomer'])->name('customer');
        Route::post('supplier', [MrpImportController::class, 'importFileSupplier'])->name('supplier');
        Route::post('unit', [MrpImportController::class, 'importFileUnit'])->name('unit');
        Route::post('material', [MrpImportController::class, 'importFileMaterial'])->name('material');
        Route::post('machine', [MrpImportController::class, 'importFileMachine'])->name('machine');
        Route::post('bom', [MrpImportController::class, 'importFileBom'])->name('bom');
        Route::post('process', [MrpImportController::class, 'importFileProcess'])->name('process');
        Route::post('product', [MrpImportController::class, 'importFileProduct'])->name('product');
        Route::post('problem', [MrpImportController::class, 'importFileProblem'])->name('problem');
        Route::post('counter-measure', [MrpImportController::class, 'importFileCounterMeasure'])->name('counter-measure');
        Route::post('vehicle', [MrpImportController::class, 'importFilevehicle'])->name('vehicle');
        Route::post('shift', [MrpImportController::class, 'importFileShift'])->name('shift');
        Route::post('inventory-material', [MrpImportController::class, 'importFileInventoryMaterial'])->name('inventory-material');
        
    });
    
