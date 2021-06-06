<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [DashboardController::class, 'index'])->name('/');
Route::post('track_order', [DashboardController::class, 'track_order'])->name('track_order');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin')->group(function () {

    Route::prefix('user_roles')->name('.user_roles')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserRoleController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Admin\UserRoleController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Admin\UserRoleController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Admin\UserRoleController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Admin\UserRoleController::class, 'delete'])->name('.delete');
    });

    Route::prefix('users')->name('.users')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Admin\UserController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Admin\UserController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Admin\UserController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Admin\UserController::class, 'delete'])->name('.delete');
    });

    Route::prefix('features')->name('.features')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\FeatureController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Admin\FeatureController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Admin\FeatureController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Admin\FeatureController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Admin\FeatureController::class, 'delete'])->name('.delete');
        Route::post('reposition', [App\Http\Controllers\Admin\FeatureController::class, 'reposition'])->name('.reposition');
    });

    Route::prefix('profiles')->name('.profiles')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ProfileController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Admin\ProfileController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Admin\ProfileController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Admin\ProfileController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Admin\ProfileController::class, 'delete'])->name('.delete');
    });

});

Route::prefix('vehicles')->group(function () {
    Route::get('/', [VehicleController::class, 'index'])->name('vehicles');
    Route::post('search', [VehicleController::class, 'search'])->name('vehicles.search');
    Route::post('info', [VehicleController::class, 'info'])->name('vehicles.info');
    Route::post('save', [VehicleController::class, 'save'])->name('vehicles.save');
    Route::post('delete', [VehicleController::class, 'delete'])->name('vehicles.delete');
});

Route::prefix('delivery_orders')->group(function () {
    Route::get('/', [DeliveryOrderController::class, 'index'])->name('delivery_orders');
    Route::post('search', [DeliveryOrderController::class, 'search'])->name('delivery_orders.search');
    Route::post('info', [DeliveryOrderController::class, 'info'])->name('delivery_orders.info');
    Route::post('save', [DeliveryOrderController::class, 'save'])->name('delivery_orders.save');
    Route::post('delete', [DeliveryOrderController::class, 'delete'])->name('delivery_orders.delete');
});

// roles
// features
// users
// credentials
// user_roles
// user_profiles
// locations
// drivers
// shipment_orders
// shipment_order_items
// shipment_invoices
// delivery_order_items
// delivery_invoices
// delivery_order_drivers
// vehicle_locations
// drivers_location
