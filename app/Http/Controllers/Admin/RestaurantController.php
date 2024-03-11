<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\Restaurant;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        return view('admin.restaurants.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRestaurantRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRestaurantRequest $request)
    {
        $new_restaurant = new Restaurant();
        $new_restaurant->user_id = Auth::id();

        $new_restaurant->fill($request->validated());

        if ($request->hasFile('cover_image')) {
            $new_restaurant->cover_image = Storage::put('images', $request->cover_image);
        }

        $this->checkUser($new_restaurant);

        $new_restaurant->save();

        if($request->has('types')) {
            $new_restaurant->types()->attach($request->types);
        }

        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        $types = Type::all();

        $this->checkUser($restaurant);

        return view('admin.restaurants.edit', compact('restaurant', 'types'));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRestaurantRequest $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $this->checkUser($restaurant);

        $data = $request->validated();

        if($request->hasFile('cover_image')) {
            if($restaurant->cover_image) {
                Storage::delete('cover_image');
            }
            $path = Storage::put('images', $request->cover_image);
            $data['cover_image'] = $path;
        }

        $restaurant->update($data);

        if($request->has('types')) {
            $restaurant->types()->sync($request->types);
        } else {
            $restaurant->types()->sync([]);
        }

        return redirect()->route('admin.dashboard')->with('message', 'Modifica del ristorante effettuata');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $this->checkUser($restaurant);

        if ($restaurant->cover_image) {
            Storage::delete('cover_image');
        }

        $restaurant->delete();

        return redirect()->route('admin.dashboard')->with('message', "Il tuo ristorante e' stato eliminato");
    }

      /**
     * Check currently user
     *
     * @param  Restaurant $restaurant
     * @return \Illuminate\Http\Response
     */
    private function checkUser(Restaurant $restaurant)
    {
        if (!$restaurant || $restaurant->user_id !== Auth::id()) {
            abort(404);
        }
    }
}
