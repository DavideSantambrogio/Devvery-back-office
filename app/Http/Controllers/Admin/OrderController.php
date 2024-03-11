<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->first();
        $total_orders = Order::where('restaurant_id', $restaurant->id)->where('status', 0)->get();
        $orders_list = Order::where('restaurant_id', $restaurant->id)->where('status', 0)
            ->orderBy('created_at')->paginate(15);

        foreach ($orders_list as $order) {
            $order->formatted_created_at = $order->created_at->format('d/m/Y  -  H:i');
        };

        return view('admin.orders.index', compact('orders_list', 'total_orders'));
    }

    /**
     * Display a listing of the resource complete.
     */
    public function indexComplete()
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->first();
        $orders_complete = Order::where('restaurant_id', $restaurant->id)->where('status', 1)
            ->orderBy('created_at', 'desc')->paginate(15);

        foreach ($orders_complete as $order) {
            $order->formatted_created_at = $order->created_at->format('d/m/Y  -  H:i');
        };

        return view('admin.orders.index_complete', compact('orders_complete', 'restaurant'));
    }

    /**
     * Check order.
     */
    public function checkOrder($id)
    {
        $order = Order::find($id);

        $this->checkRestaurant($order);

        $order->status = 1;
        $order->update();

        return redirect()->route('admin.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::find($id);

        $this->checkRestaurant($order);

        $appetizers = $order->foods->where('category_id', 1);
        $first_dishes = $order->foods->where('category_id', 2);
        $second_dishes = $order->foods->where('category_id', 3);
        $side_dishes = $order->foods->where('category_id', 4);
        $sweets = $order->foods->where('category_id', 5);

        return view('admin.orders.show', compact('order', 'appetizers', 'first_dishes', 'second_dishes', 'side_dishes', 'sweets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Check currently user
     *
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function checkRestaurant($order)
    {
        if (!$order || $order->restaurant_id !== Auth::user()->restaurant->id) {
            abort(404);
        }
    }
}
