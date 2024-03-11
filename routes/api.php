<?php

use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\TypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API RESTAURANTS
Route::get('restaurants', [RestaurantController::class, 'index']);
Route::get('restaurants/searchText/{string}', [RestaurantController::class, 'searchText']);
Route::get('restaurants/types', [RestaurantController::class, 'types']);
Route::get('restaurants/{slug}', [RestaurantController::class, 'show']);

// API FOODS
Route::get('foods', [FoodController::class, 'index']);
Route::get('foods/{id}', [FoodController::class, 'show']);

// API TYPE
Route::get('types', [TypeController::class, 'index']);

// API ORDER
Route::post('orders', [OrderController::class, 'store']);
Route::post('orders/validation', [OrderController::class, 'validation']);
Route::get('orders/generate', [OrderController::class, 'generate']);
Route::post('orders/make/payment', [OrderController::class, 'makePayment']);
