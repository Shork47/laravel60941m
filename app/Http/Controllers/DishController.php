<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
        return view('dish_create', ['categories' => Category::all(), 'ingredients' => Ingredient::all()]);
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
            'category_id' => 'required|integer',
            'ingredients' => 'required|array|exists:ingredients,id',
            'quantities' => 'required|array|min:1',
        ]);

        $dish = new Dish($validated);
        $dish->user_id = auth()->id();
        $dish->save();

        foreach ($validated['ingredients'] as $index => $ingredientId) {
            $dish->ingredient()->attach($ingredientId, ['quantity' => $validated['quantities'][$index]]);
        }

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
            'dish' => Dish::with(['ingredient' => function ($query) {
                $query->select('ingredients.id', 'name', 'units', 'quantity')
                    ->withPivot('quantity'); // Загружаем количество из pivot-таблицы (recipes)
            }])->findOrFail($id),
            'categories' => Category::all(),
            'ingredients' => Ingredient::all(),
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
            'ingredients' => 'required|array', // массив с ингредиентами
            'quantities' => 'required|array',  // массив с количеством для каждого ингредиента
            'ingredients.*' => 'integer|exists:ingredients,id', // проверка, что каждый ингредиент существует
            'quantities.*' => 'integer|min:1', // проверка на количество
        ]);

        // Получаем блюдо по ID
        $dish = Dish::all()->where('id', $id)->first();

        // Обновляем основные поля блюда
        $dish->name = $validated['name'];
        $dish->cooking_method = $validated['cooking_method'];
        $dish->cooking_time = $validated['cooking_time'];
        $dish->category_id = $validated['category_id'];
        $dish->save();

        // Обновляем ингредиенты блюда
        $ingredients = $validated['ingredients'];
        $quantities = $validated['quantities'];
        $ingredientData = [];

        foreach ($ingredients as $index => $ingredientId) {
            $ingredientData[$ingredientId] = ['quantity' => $quantities[$index]];
        }

        // Синхронизируем ингредиенты в промежуточной таблице с их количеством
        $dish->ingredient()->sync($ingredientData);

        return redirect()->route('dish.show',['id'=> $dish->id])->withErrors('success', 'Блюдо обновлено успешно');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (! Gate::allows('destroy-dish', Dish::all()->where('id', $id)->first())) {
            return redirect('/error')->with('message', 'У вас нет разрешение на удаление блюда номер ' . $id);
        }
        Dish::destroy($id);
        return redirect('/dish')->withErrors(['error'=>'Блюдо успешно удалено!']);
    }
}
