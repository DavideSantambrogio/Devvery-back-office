<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $restaurants = config('restaurants');

        foreach ($restaurants as $restaurant) {
            $new_restaurant = new Restaurant();
            $new_restaurant->name = $restaurant['name'];
            $new_restaurant->address = $restaurant['address'];;
            $new_restaurant->description = $restaurant['description'];
            $new_restaurant->phone = $restaurant['phone'];
            $new_restaurant->cover_image = $restaurant['cover_image'];
            $new_restaurant->user_id = $restaurant['user_id'];
            $new_restaurant->save();
        }
    }
}
