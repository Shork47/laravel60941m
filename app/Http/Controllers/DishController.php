<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        $perpage = $request->perpage ?? 2;
        return view('dishes', ['dishes' => Dish::orderBy('id', 'asc')->paginate($perpage)->withQueryString()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dish_create', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'cooking_method' => 'required|string',
            'cooking_time' => 'required|integer',
            'category_id' => 'integer',
        ]);
        $dish = new Dish($validated);
        $dish->save();
        return redirect('/dish');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('dish', [
            'dish' => Dish::all()->where('id', $id)->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dish_edit', [
            'dish' => Dish::all()->where('id', $id)->first(),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'cooking_method' => 'required|string',
            'cooking_time' => 'required|integer',
            'category_id' => 'integer',
        ]);
        $dish = Dish::all()->where('id', $id)->first();
        $dish->name = $validated['name'];
        $dish->cooking_method = $validated['cooking_method'];
        $dish->cooking_time = $validated['cooking_time'];
        $dish->category_id = $validated['category_id'];
        $dish->save();
        return redirect('/dish');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Dish::destroy($id);
        return redirect('/dish');
    }
}
