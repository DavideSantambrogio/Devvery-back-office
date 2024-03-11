<?php

namespace Database\Seeders;

use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_details = [
            [
                'vat_number' => '12345678901',
                'phone' => '1234567890',
                'address' => 'Via Roma 123',
                'user_id' => 1,
            ],
            [
                'vat_number' => '22998855',
                'phone' => '3958877556',
                'address' => 'Via nazionale 15',
                'user_id' => 2,
            ],
            [
                'vat_number' => '59515377',
                'phone' => '2548597835',
                'address' => 'Via del vespro 42',
                'user_id' => 3,
            ],
            [
                'vat_number' => '59534234234',
                'phone' => '342342432424',
                'address' => 'Via del vespro 42',
                'user_id' => 4,
            ],
            [
                'vat_number' => '43242432423',
                'phone' => '234243242432',
                'address' => 'Via del vespro 42',
                'user_id' => 5,
            ],
            [
                'vat_number' => '65464646456',
                'phone' => '34242342423242',
                'address' => 'Via del vespro 42',
                'user_id' => 6,
            ],
            [
                'vat_number' => '75674546456',
                'phone' => '3242432432424',
                'address' => 'Via del vespro 42',
                'user_id' => 7,
            ],
        ];

        foreach ($user_details as $user_detail) {
            $new_user_detail = new UserDetail();
            $new_user_detail->vat_number = $user_detail['vat_number'];
            $new_user_detail->phone = $user_detail['phone'];
            $new_user_detail->address = $user_detail['address'];
            $new_user_detail->user_id = $user_detail['user_id'];
            $new_user_detail->save();
        }
    }
}
