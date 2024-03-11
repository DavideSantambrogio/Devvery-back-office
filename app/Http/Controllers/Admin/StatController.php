<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
  public function index()
  {
    $restaurant = Restaurant::where('user_id', Auth::id())->first();

    if (!$restaurant) {
      abort(404);
    }

    $orders = $restaurant->orders;
    return view('admin.stats.index', compact('orders'));
  }

  public function getDataChart()
  {
    $currentYear = Carbon::now()->year;
    $currentMonth = Carbon::now()->month;

    // Calcoliamo l'anno e il mese di 12 mesi fa
    $yearAgo = $currentYear;
    $monthAgo = $currentMonth - 11;
    if ($monthAgo <= 0) {
      $yearAgo--;
      $monthAgo += 12;
    }

    // Creiamo un array di tutti i mesi dell'ultimo anno
    $months = [];
    for ($i = 0; $i < 12; $i++) {
      $months[] = Carbon::create($yearAgo, $monthAgo + $i, 1)->month;
    }

    $orders_worked_months = Order::select([
      DB::raw('MONTH(`created_at`) as x'),
      DB::raw('COUNT(0) as orders')
    ])
      ->where('restaurant_id', Auth::id())
      ->whereBetween('created_at', [Carbon::create($yearAgo, $monthAgo, 1), Carbon::now()])
      ->groupBy(DB::raw('MONTH(`created_at`)'))
      ->orderBy(DB::raw('MONTH(`created_at`)'))
      ->get();

    $orders_data = $orders_worked_months->pluck('orders', 'x')->toArray();

    $orders_month = array_map(function ($month) use ($orders_data) {
      return [
        'x' => $month,
        'orders' => $orders_data[$month] ?? 0,
      ];
    }, $months);

    return response()->json($orders_month);
  }


  public function getDataChartYear()
  {


    $orders_year = Order::select([
      DB::raw('YEAR(`created_at`) as year'),
      DB::raw('COUNT(0) as orders')
    ])
      ->where('restaurant_id', Auth::id())
      ->groupBy(DB::raw('YEAR(`created_at`)'))
      ->orderBy(DB::raw('YEAR(`created_at`)'))
      ->get();


    $years = $orders_year->pluck('year')->toArray();


    $range_years = range(min($years), max($years));


    $orders_data = $orders_year->pluck('orders', 'year')->toArray();


    $merged_data = array_map(function ($year) use ($orders_data) {
      return [
        'year' => $year,
        'orders' => $orders_data[$year] ?? 0,
      ];
    }, $range_years);


    $data = [
      'orders' => $merged_data,
      'years' => $range_years
    ];


    return response()->json($data);
  }

  public function getAmountChartMonth()
  {
    $currentYear = Carbon::now()->year;
    $currentMonth = Carbon::now()->month;

    // Calcoliamo l'anno e il mese di 12 mesi fa
    $yearAgo = $currentYear;
    $monthAgo = $currentMonth - 11;
    if ($monthAgo <= 0) {
      $yearAgo--;
      $monthAgo += 12;
    }

    // Creiamo un array di tutti i mesi degli ultimi 12 mesi
    $months = [];
    for ($i = 0; $i < 12; $i++) {
      $months[] = Carbon::create($yearAgo, $monthAgo + $i, 1)->month;
    }

    $amount_worked_months = Order::select([
      DB::raw('MONTH(`created_at`) as x'),
      DB::raw('SUM(total_amount) as total')
    ])
      ->where('restaurant_id', Auth::id())
      ->whereBetween('created_at', [Carbon::create($yearAgo, $monthAgo, 1), Carbon::now()])
      ->groupBy(DB::raw('MONTH(`created_at`)'))
      ->orderBy(DB::raw('MONTH(`created_at`)'))
      ->get();

    $amount_data = $amount_worked_months->pluck('total', 'x')->toArray();

    $amount_month = array_map(function ($month) use ($amount_data) {
      return [
        'x' => $month,
        'total' => $amount_data[$month] ?? 0,
      ];
    }, $months);

    return response()->json($amount_month);
  }

  public function getAmountChartYear()
  {


    $orders_year = Order::select([
      DB::raw('YEAR(`created_at`) as year'),
      DB::raw('SUM(total_amount) as amount')
    ])
      ->where('restaurant_id', Auth::id())
      ->groupBy(DB::raw('YEAR(`created_at`)'))
      ->orderBy(DB::raw('YEAR(`created_at`)'))
      ->get();



    $years = $orders_year->pluck('year')->toArray();


    $range_years = range(min($years), max($years));


    $amount_data = $orders_year->pluck('amount', 'year')->toArray();


    $merged_data = array_map(function ($year) use ($amount_data) {
      return [
        'year' => $year,
        'amount' => $amount_data[$year] ?? 0,
      ];
    }, $range_years);


    $data = [
      'amount' => $merged_data,
      'years' => $range_years
    ];


    return response()->json($data);
  }

  public function bestsFoods()
  {
    $restaurantId = Auth::user()->restaurant->id;

    $mostOrderedFoods = DB::table('foods')
      ->select('foods.name', DB::raw('SUM(food_order.quantity_ordered) as total_ordered'))
      ->join('food_order', 'foods.id', '=', 'food_order.food_id')
      ->join('orders', 'orders.id', '=', 'food_order.order_id')
      ->where('orders.restaurant_id', $restaurantId)
      ->groupBy('foods.name')
      ->orderByDesc('total_ordered')
      ->take(3) // Prendi solo i primi 3 risultati
      ->get();

    if ($mostOrderedFoods->isNotEmpty()) {
      return response()->json($mostOrderedFoods);
    } else {
      return response()->json(['message' => 'No orders found for the specified restaurant'], 404);
    }
  }
}
