<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Pasticceria',
                'description' => 'Goditi la nostra vasta scelta di buonissimi dolci'
            ],
            [
                'name' => 'Hamburger',
                'description' => 'I veri hamburger come non li hai mai assaggiati'
            ],
            [
                'name' => 'Gourmet',
                'description' => 'Lasciati coccolare dai nostri Chef e riscopri nuovi sapori mai provati'
            ],
            [
                'name' => 'Giapponese',
                'description' => 'Il miglior Sushi di Milano a portata di click'
            ],
            [
                'name' => 'Cinese',
                'description' => 'Tante nuove emozioni culinarie, in questo viaggio nel lontano oriente'
            ],
            [
                'name' => 'Trattoria',
                'description' => 'Ritrova i sapori della tipica cucina Italiana in questo salto nel passato'
            ],
            [
                'name' => 'Pizzeria',
                'description' => 'Il piatto Italiano per eccellenza ! Da noi trovi solo le migliori pizzerie della zona selezionate per te'
            ],
            [
                'name' => 'FastFood',
                'description' => 'Vuoi goderti un piatto veloce e buonissimo ? Questa è la sezione adatta a te !'
            ],
        ];

        foreach ($types as $type) {
            $new_type = new Type();
            $new_type->name = $type['name'];
            $new_type->description = $type['description'];
            $new_type->save();
        }
    }
}
