<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    // TUTTI I CIBI
    public function index()
    {
        // $foods = Food::with('category')->get();
        $foods = Food::with('restaurant')->get();

        // return FoodResource::collection($foods);

        return response()->json([
            'result' => $foods,
            'success' => true
        ]);
    }

    // IL SINGOLO CIBO DI UN RISTORANTE
    public function show(string $id)
    {
        $food = Food::with('category', 'restaurant')->where('id', $id)->first();

        if ($food) {
            return response()->json([
                'result' => $food,
                'success' => true
            ]);
        } else {
            return response()->json([
                'result' => 'Cibo non trovato',
                'success' => false,
            ]);
        }
    }
}
