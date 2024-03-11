<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\Admin\UserDetailController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Trash and softDelete foods
        Route::get('foods/trash', [FoodController::class, 'trash'])->name('foods.trash');
        Route::post("foods/restore/{food}", [FoodController::class, "restore"])->withTrashed()->name('foods.restore');
        Route::delete("foods/def_destroy/{food}", [FoodController::class, "defDestroy"])->withTrashed()->name('foods.def_destroy');
        
        // Resource
        Route::get('orders/complete', [OrderController::class, 'indexComplete'])->name('orders.complete');
        Route::resource('orders', OrderController::class);
        Route::post('orders/check/{order}', [OrderController::class, 'checkOrder'])->name('order.check');
        
        Route::resource('restaurants', RestaurantController::class)->parameters(['restaurants' => 'restaurant:slug']);
        Route::resource('userDetails', UserDetailController::class);
        Route::resource('foods', FoodController::class);
       
        // Stats Routes
        Route::get('stats', [StatController::class, 'index'])->name('stats');
        Route::get('charts/order/month', [StatController::class, 'getDataChart'])->name('getDataChart');
        Route::get('charts/order/year', [StatController::class, 'getDataChartYear'])->name('getDataChartYear');
        Route::get('charts/amount/month', [StatController::class, 'getAmountChartMonth'])->name('getAmountChartMonth');
        Route::get('charts/amount/year', [StatController::class, 'getAmountChartYear'])->name('getAmountChartYear');
        Route::get('chart/most-ordered-food', [StatController::class, 'bestsFoods'])->name('bestsFoods');

    });

require __DIR__ . '/auth.php';
