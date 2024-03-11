<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Models\Category;
use App\Models\Food;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->first();

        if (!$restaurant) {
            abort(404);
        }

        $foods = $restaurant->foods()->orderBy('category_id')->paginate(24);

        return view('admin.foods.index', compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.foods.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreFoodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFoodRequest $request)
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->first();
        $new_food = new Food();

        $new_food->fill($request->validated());
        

        if ($request->hasFile('cover_image')) {
            $new_food->cover_image = Storage::put('images', $request->cover_image);
        }

        $new_food->restaurant_id = $restaurant->id;

        if ($request->has('vegan')) {
            $new_food->vegan = true;
        }

        if ($request->has('celiac')) {
            $new_food->celiac = true;
        }

        $this->checkRestaurant($new_food);

        $new_food->save();

        return redirect()->route('admin.foods.index')->with('message', 'Piatto creato con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $food = Food::find($id);

        $this->checkRestaurant($food);

        return view('admin.foods.show', compact('food'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $food = Food::find($id);

        $this->checkRestaurant($food);

        return view('admin.foods.edit', compact('food', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateFoodRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFoodRequest $request, $id)
    {
        $food = Food::find($id);

        $this->checkRestaurant($food);

        $food_data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($food->cover_image) {
                Storage::delete('cover_image');
            }
            $path = Storage::put('images', $request->cover_image);
            $food_data['cover_image'] = $path;
        }

        if ($request->has('celiac')) {
            $food_data['celiac'] = true;
        } else {
            $food_data['celiac'] = false;
        }

        if ($request->has('vegan')) {
            $food_data['vegan'] = true;
        } else {
            $food_data['vegan'] = false;
        }

        if ($request->has('available')) {
            $food_data['available'] = true;
        } else {
            $food_data['available'] = false;
        }

        $food->update($food_data);

        return redirect()->route('admin.foods.show', ['food' => $food->id])->with('message', 'Piatto aggiornato con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $food = Food::find($id);

        $this->checkRestaurant($food);

        $food->delete();

        return redirect()->route('admin.foods.index')->with('message', 'Piatto cancellato con successo');
    }

    /**
     * Delete the specified resource from trash.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function defDestroy($id)
    {
        $food = Food::withTrashed()->find($id);

        $this->checkRestaurant($food);

        $food->forceDelete();

        return redirect()->back()->with('def_del_mess', "$food->name e' stato definitivamente eliminato");
    }

    /**
     * Displays deleted items.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->first();

        if (!$restaurant) {
            abort(404);
        }

        $foods = $restaurant->foods()->onlyTrashed()->paginate(24);
        $food_deleted = $foods->where('deleted_at', '!=', null);

        return view('admin.foods.trash', compact('foods', 'food_deleted'));
    }


    /**
     * Restore deleted items.
     * 
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $food = food::withTrashed()->find($id);

        $this->checkRestaurant($food);

        $food->restore();

        return redirect()->back()->with('message', "$food->name e' stato ripristinato");
    }

    /**
     * Check currently user
     *
     * @param  Food  $food
     * @return \Illuminate\Http\Response
     */
    public function checkRestaurant($food)
    {
        if (!$food || $food->restaurant_id !== Auth::user()->restaurant->id) {
            abort(404);
        }
    }
}
