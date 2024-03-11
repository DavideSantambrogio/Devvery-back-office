<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class OrdersTableSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $restaurants = Restaurant::all();

        $ordersPerRestaurant = 100;

        foreach ($restaurants as $restaurant) {
            for ($i = 0; $i < $ordersPerRestaurant; $i++) {
                $new_order = new Order();
                $new_order->restaurant_id = $restaurant->id;
                $new_order->customer_id = rand(1, 20);
                $new_order->status = 1;
                $new_order->created_at = $faker->dateTimeBetween('-600 day', now());
                $new_order->save();

                $foods = Food::where('restaurant_id', $restaurant->id)->inRandomOrder()->limit(rand(1, 5))->get();

                $totalAmount = 0;
                foreach ($foods as $food) {
                    $quantityOrdered = rand(1, 5);
                    $totalAmount += $food->price * $quantityOrdered; 
                    $new_order->foods()->attach($food, ['quantity_ordered' => $quantityOrdered]);
                }

                $new_order->total_amount = $totalAmount;
                $new_order->save();
            }
        }
    }
}
