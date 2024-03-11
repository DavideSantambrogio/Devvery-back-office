<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        for ($i = 0; $i < 20; $i++) {
            $gender = $faker->randomElement(['male', 'female']);

            $new_customer = new Customer();
            $new_customer->first_name = $faker->firstName($gender);
            $new_customer->last_name = $faker->lastName();
            $new_customer->address = $faker->address();
            $new_customer->phone = $faker->phoneNumber();
            $new_customer->save();
        }
    }
}
