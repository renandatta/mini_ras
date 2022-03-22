<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');
Route::get('track_order', [App\Http\Controllers\HomeController::class, 'track_order'])->name('track_order');

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

Route::prefix('owner')->name('owner')->group(function () {

    Route::get('/', [App\Http\Controllers\Owner\HomeController::class, 'index']);

    Route::prefix('profile')->name('.profile')->group(function () {
        Route::get('/', [App\Http\Controllers\Owner\ProfileController::class, 'index']);
        Route::post('save', [App\Http\Controllers\Owner\ProfileController::class, 'save'])->name('.save');
    });

    Route::prefix('users')->name('.users')->group(function () {
        Route::get('/', [App\Http\Controllers\Owner\UserController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Owner\UserController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Owner\UserController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Owner\UserController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Owner\UserController::class, 'delete'])->name('.delete');
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

    Route::prefix('drivers')->name('.drivers')->group(function () {
        Route::get('/', [App\Http\Controllers\Transporter\DriverController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Transporter\DriverController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Transporter\DriverController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Transporter\DriverController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Transporter\DriverController::class, 'delete'])->name('.delete');
    });

    Route::prefix('delivery_orders')->name('.delivery_orders')->group(function () {
        Route::get('/', [App\Http\Controllers\Transporter\DeliveryOrderController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Transporter\DeliveryOrderController::class, 'search'])->name('.search');
        Route::post('save', [App\Http\Controllers\Transporter\DeliveryOrderController::class, 'save'])->name('.save');
        Route::post('info', [App\Http\Controllers\Transporter\DeliveryOrderController::class, 'info'])->name('.info');
    });

});

Route::prefix('consignee')->name('consignee')->group(function () {

    Route::get('/', [App\Http\Controllers\Consignee\HomeController::class, 'index']);

    Route::prefix('locations')->name('.locations')->group(function () {
        Route::get('/', [App\Http\Controllers\Consignee\LocationController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Consignee\LocationController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Consignee\LocationController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Consignee\LocationController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Consignee\LocationController::class, 'delete'])->name('.delete');
    });

});

Route::prefix('shipper')->name('shipper')->group(function () {

    Route::get('/', [App\Http\Controllers\Shipper\HomeController::class, 'index']);

    Route::prefix('locations')->name('.locations')->group(function () {
        Route::get('/', [App\Http\Controllers\Shipper\LocationController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Shipper\LocationController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Shipper\LocationController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Shipper\LocationController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Shipper\LocationController::class, 'delete'])->name('.delete');
    });

    Route::prefix('shipment_orders')->name('.shipment_orders')->group(function () {
        Route::get('/', [App\Http\Controllers\Shipper\ShipmentOrderController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Shipper\ShipmentOrderController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Shipper\ShipmentOrderController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Shipper\ShipmentOrderController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Shipper\ShipmentOrderController::class, 'delete'])->name('.delete');

        Route::prefix('items')->name('.items')->group(function () {
            Route::post('info', [App\Http\Controllers\Shipper\ShipmentOrderItemController::class, 'info'])->name('.info');
            Route::post('search', [App\Http\Controllers\Shipper\ShipmentOrderItemController::class, 'search'])->name('.search');
            Route::post('save', [App\Http\Controllers\Shipper\ShipmentOrderItemController::class, 'save'])->name('.save');
            Route::post('delete', [App\Http\Controllers\Shipper\ShipmentOrderItemController::class, 'delete'])->name('.delete');
        });
    });

    Route::prefix('delivery_orders')->name('.delivery_orders')->group(function () {
        Route::get('/', [App\Http\Controllers\Shipper\DeliveryOrderController::class, 'index']);
        Route::post('info', [App\Http\Controllers\Shipper\DeliveryOrderController::class, 'info'])->name('.info');
        Route::post('search', [App\Http\Controllers\Shipper\DeliveryOrderController::class, 'search'])->name('.search');
        Route::post('save', [App\Http\Controllers\Shipper\DeliveryOrderController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Shipper\DeliveryOrderController::class, 'delete'])->name('.delete');

        Route::prefix('items')->name('.items')->group(function () {
            Route::post('search', [App\Http\Controllers\Shipper\DeliveryOrderItemController::class, 'search'])->name('.search');
        });

        Route::prefix('timelines')->name('.timelines')->group(function () {
            Route::post('search', [App\Http\Controllers\Shipper\DeliveryOrderTimelineController::class, 'search'])->name('.search');
        });
    });

    Route::prefix('customers')->name('.customers')->group(function () {
        Route::get('/', [App\Http\Controllers\Shipper\CustomerController::class, 'index']);
        Route::post('search', [App\Http\Controllers\Shipper\CustomerController::class, 'search'])->name('.search');
        Route::post('info', [App\Http\Controllers\Shipper\CustomerController::class, 'info'])->name('.info');
        Route::post('save', [App\Http\Controllers\Shipper\CustomerController::class, 'save'])->name('.save');
        Route::post('delete', [App\Http\Controllers\Shipper\CustomerController::class, 'delete'])->name('.delete');

        Route::prefix('{customer_id}/locations')->name('.locations')->group(function () {
            Route::get('/', [App\Http\Controllers\Shipper\CustomerLocationController::class, 'index']);
            Route::post('search', [App\Http\Controllers\Shipper\CustomerLocationController::class, 'search'])->name('.search');
            Route::post('info', [App\Http\Controllers\Shipper\CustomerLocationController::class, 'info'])->name('.info');
            Route::post('save', [App\Http\Controllers\Shipper\CustomerLocationController::class, 'save'])->name('.save');
            Route::post('delete', [App\Http\Controllers\Shipper\CustomerLocationController::class, 'delete'])->name('.delete');
        });

    });

});
