<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Oee\OeeDashboardController;
use App\Http\Controllers\AccessManagementController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

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

Route::get('/',  [HomeController::class, 'index'])->name('home');

Route::prefix('access-management')->name('access-management.')->middleware('auth')->group(function () {
    Route::get('/', [AccessManagementController::class, 'index']);

    Route::get('/user-list', [AccessManagementController::class, 'userList'])->name('user-list');
    Route::get('/user-create', [AccessManagementController::class, 'userCreate'])->name('user-create');
    Route::get('/user-edit/{id}', [AccessManagementController::class, 'userEdit'])->name('user-edit');
    Route::post('/user-store', [AccessManagementController::class, 'userStore'])->name('user-store');
    Route::delete('/user-delete', [AccessManagementController::class, 'userDelete'])->name('user-delete');
    Route::patch('/user-store/{id}', [AccessManagementController::class, 'userUpdate'])->name('user-update');
    Route::get('/user-profile/{id}', [AccessManagementController::class, 'userProfile'])->name('user-profile');

    
    Route::get('/role-list', [RoleController::class, 'index'])->name('role-list');
    Route::get('/role-create', [RoleController::class, 'create'])->name('role-create');
    Route::get('/role-edit/{id}', [RoleController::class, 'edit'])->name('role-edit');
    Route::post('/role-store', [RoleController::class, 'store'])->name('role-store');
    Route::delete('/role-delete', [RoleController::class, 'delete'])->name('role-delete');
    Route::patch('/role-store/{id}', [RoleController::class, 'update'])->name('role-update');

    Route::get('/permission-list', [PermissionController::class, 'index'])->name('permission-list');
    Route::get('/permission-create', [PermissionController::class, 'create'])->name('permission-create');
    Route::get('/permission-edit/{id}', [PermissionController::class, 'edit'])->name('permission-edit');
    Route::post('/permission-store', [PermissionController::class, 'store'])->name('permission-store');
    Route::patch('/permission-store/{id}', [PermissionController::class, 'update'])->name('permission-update');
    Route::delete('/permission-delete', [PermissionController::class, 'delete'])->name('permission-delete');
});

Auth::routes();

Route::get('/login-dev', function () {
    $data['page_title'] = 'Login';
    return view('auth.login-dev',$data);
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

