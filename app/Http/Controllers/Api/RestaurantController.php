<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Restaurant;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class RestaurantController extends Controller
{
    // TUTTI I RISTORANTI CON LE CATEGORIE ASSOCIATE
    public function index()
    {
        $restaurant = Restaurant::with('types')->get();

        return response()->json([
            'result' => $restaurant,
            'success' => true
        ]);
    }

    // IL SINGOLO RISTORANTE MOSTRA I CIBI AL SUO INTERNO
    public function show(string $slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->first();

        if ($restaurant) {
            $foods = Food::with('category', 'restaurant')->where('restaurant_id', $restaurant->id)->where('available', true)->get();
        }

        if ($restaurant) {
            return response()->json([
                'restaurant' => $restaurant,
                'foods' => $foods,
                'success' => true
            ]);
        } else {
            return response()->json([
                'result' => 'ristorante non trovato',
                'success' => false
            ]);
        }
    }

    // TUTTI I RISTORANTI CHE HANNO LA CATEGORIA SCELTA
    public function types(Request $request)
    {
        $types = $request->input('types', []);
        $restaurants = Restaurant::query()->with('types');
        // $allRestaurant = Restaurant::with('types')->get();
        // $restaurants = $allRestaurant::query();

        foreach ($types as $type) {
            $restaurants->whereHas('types', function ($query) use ($type) {
                $query->where('name', $type);
            });
        }

        $restaurants = $restaurants->get();

        if ($restaurants->count() > 0) {
            return response()->json([
                'result' => $restaurants,
                'success' => true
            ]);
        } else {
            return response()->json([
                'result' => 'ristorante non trovato',
                'success' => false
            ]);
        }
    }

    // TUTTI I RISTORANTI CHE HANNO QUELLA STRINGA NEL NOME
    public function searchText(string $string)
    {
        $restaurants = Restaurant::with('types')->where('name', 'like', '%' . $string . '%')->get();

        if ($restaurants) {
            return response()->json([
                'result' => $restaurants,
                'success' => true
            ]);
        } else {
            return response()->json([
                'result' => 'ristorante non trovato',
                'success' => false
            ]);
        }
    }
}
