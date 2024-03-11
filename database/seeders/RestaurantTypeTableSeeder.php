<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $relations = [
            [
                "restaurant" => 1,
                "type" => 6
            ],
            [
                "restaurant" => 1,
                "type" => 7
            ],
            [
                "restaurant" => 2,
                "type" => 2
            ],
            [
                "restaurant" => 2,
                "type" => 6
            ],
            [
                "restaurant" => 3,
                "type" => 1
            ],
            [
                "restaurant" => 4,
                "type" => 1
            ],
            [
                "restaurant" => 4,
                "type" => 2
            ],
            [
                "restaurant" => 5,
                "type" => 2
            ],
            [
                "restaurant" => 6,
                "type" => 3
            ],
            [
                "restaurant" => 6,
                "type" => 4
            ],
            [
                "restaurant" => 7,
                "type" => 1
            ],
            [
                "restaurant" => 7,
                "type" => 3
            ],
            [
                "restaurant" => 7,
                "type" => 6
            ],
            [
                "restaurant" => 8,
                "type" => 4
            ],
            [
                "restaurant" => 9,
                "type" => 5
            ],
            [
                "restaurant" => 10,
                "type" => 4
            ],
            [
                "restaurant" => 10,
                "type" => 5
            ],
            [
                "restaurant" => 11,
                "type" => 3
            ],
            [
                "restaurant" => 11,
                "type" => 4
            ],
            [
                "restaurant" => 11,
                "type" => 5
            ],
            [
                "restaurant" => 11,
                "type" => 6
            ],
            [
                "restaurant" => 12,
                "type" => 7
            ],
            [
                "restaurant" => 13,
                "type" => 7
            ],
            [
                "restaurant" => 14,
                "type" => 1
            ],
            [
                "restaurant" => 14,
                "type" => 8
            ],
            [
                "restaurant" => 15,
                "type" => 2
            ],
            [
                "restaurant" => 15,
                "type" => 7
            ],

        ];
        foreach ($relations as $relation) {
            $restaurant = Restaurant::find($relation['restaurant']);
            $type = Type::find($relation['type']);
            $restaurant->types()->attach($type);
        }
    }
}
