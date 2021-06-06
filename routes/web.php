<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryOrderController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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

Route::get('assets/{folder}/{filename}', function ($folder,$filename){
    $path = storage_path('app/' . $folder . '/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file);
    $response->header("Content-Type", $type);
    return $response;
});

Route::get('/', [DashboardController::class, 'index'])->name('/');
Route::post('track_order', [DashboardController::class, 'track_order'])->name('track_order');

Auth::routes();
Route::get('logout', function () {
    Auth::logout();
    return redirect()->route('/');
})->name('logout');

Route::prefix('admin')->name('admin')->group(function () {

    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index']);

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

        Route::prefix('users')->name('.users')->group(function () {
            Route::post('index', [App\Http\Controllers\Admin\ProfileUserController::class, 'index']);
            Route::post('search', [App\Http\Controllers\Admin\ProfileUserController::class, 'search'])->name('.search');
            Route::post('info', [App\Http\Controllers\Admin\ProfileUserController::class, 'info'])->name('.info');
            Route::post('save', [App\Http\Controllers\Admin\ProfileUserController::class, 'save'])->name('.save');
            Route::post('delete', [App\Http\Controllers\Admin\ProfileUserController::class, 'delete'])->name('.delete');
        });

    });

});

Route::prefix('transporter')->name('transporter')->group(function () {

    Route::get('/', [App\Http\Controllers\Transporter\HomeController::class, 'index']);

    Route::prefix('vehicles')->name('.vehicles')->group(function () {
        Route::get('/', [App\Http\Controllers\Transporter\VehicleController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Transporter\VehicleController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Transporter\VehicleController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Transporter\VehicleController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Transporter\VehicleController::class, 'delete'])->name('.delete');
    });

    Route::prefix('locations')->name('.locations')->group(function () {
        Route::get('/', [App\Http\Controllers\Transporter\LocationController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Transporter\LocationController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Transporter\LocationController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Transporter\LocationController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Transporter\LocationController::class, 'delete'])->name('.delete');
    });

    Route::prefix('drivers')->name('.drivers')->group(function () {
        Route::get('/', [App\Http\Controllers\Transporter\DriverController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Transporter\DriverController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Transporter\DriverController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Transporter\DriverController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Transporter\DriverController::class, 'delete'])->name('.delete');
    });

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
