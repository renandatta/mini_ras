<?php

use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
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

Route::get('/', function () {
    return view('layouts.admin');
})->middleware(['fitur_program']);

Route::prefix('profiles')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profiles');
    Route::post('search', [ProfileController::class, 'search'])->name('profiles.search');
    Route::post('info', [ProfileController::class, 'info'])->name('profiles.info');
    Route::post('save', [ProfileController::class, 'save'])->name('profiles.save');
    Route::post('delete', [ProfileController::class, 'delete'])->name('profiles.delete');
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
