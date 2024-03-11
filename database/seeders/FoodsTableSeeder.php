<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foods_list = config('foods');
        
            foreach($foods_list as $food) {

                $new_food = new Food();
                $new_food->restaurant_id =$food['restaurant_id'];
                $new_food->name = $food['name'];
                $new_food->price = $food['price'];
                $new_food->description = $food['description'];
                $new_food->vegan = $food['vegan'];
                $new_food->celiac = $food['celiac'];
                $new_food->available = $food['available'];
                $new_food->cover_image = $food['cover_image'];
                $new_food->category_id = $food['category_id'];
                $new_food->save();
            }
        
    }
}
