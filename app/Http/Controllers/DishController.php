<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Ingredient;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        $perpage = $request->perpage ?? 4;
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
            'ingredient_names' => ['required', 'array', function ($attribute, $value, $fail) {
                foreach ($value as $ingredientInput) {
                    if (!preg_match('/^.+,\s*.+$/', $ingredientInput)) {
                        $fail('Каждый ингредиент должен быть в формате "название, единица измерения". Например: "Гречка,г".');
                    }
                }
            }],
            'quantities' => 'required|array|min:1',
//            'photos.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ],
        [
            'name.required' => 'Поле обязательно для заполения.',
            'cooking_method.required' => 'Поле обязательно для заполения.',
            'cooking_time.required' => 'Поле обязательно для заполения.',
            'category_id.required' => 'Поле обязательно для заполения.',
            'ingredient_names.required' => 'Поле обязательно для заполения.',
            'quantities.required' => 'Поле обязательно для заполения.',
        ]);

        $dish = new Dish([
            'name' => $validated['name'],
            'cooking_method' => $validated['cooking_method'],
            'cooking_time' => $validated['cooking_time'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id()
        ]);
        $dish->save();

        foreach ($validated['ingredient_names'] as $index => $ingredientInput) {
            // Разделяем строку на имя и единицу измерения
            $parts = explode(',', $ingredientInput);
            $ingredientName = trim($parts[0]);  // Имя ингредиента
            $ingredientUnit = isset($parts[1]) ? trim($parts[1]) : '';  // Единица измерения

            // Поиск ингредиента по имени и единице измерения
            $ingredient = Ingredient::where('name', $ingredientName)
                ->where('units', $ingredientUnit)
                ->first();

            // Если ингредиент с таким сочетанием не найден, создаем новый
            if (!$ingredient) {
                $ingredient = Ingredient::create([
                    'name' => $ingredientName,
                    'units' => $ingredientUnit
                ]);
            }

            // Привязываем ингредиент к блюду с нужным количеством
            $dish->ingredient()->attach($ingredient->id, ['quantity' => $validated['quantities'][$index]]);
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('photos', 'minio');

                $dish->photo()->create([
                    'path' => $path
                ]);
            }
        } else {
            return back()->withErrors(['error' => 'Необходимо добавить хотя бы одну фотографию']);
        }

        return redirect()->route('dish.show',['id'=> $dish->id]) ->withErrors('success', 'Блюдо успешно добавлено');
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
                    ->withPivot('quantity');
            }])->findOrFail($id),
            'categories' => Category::all(),
            'ingredients' => Ingredient::all(),
            'photo' => Photo::where('dish_id', $id)->get()
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
            'ingredient_names' => ['required', 'array', function ($attribute, $value, $fail) {
                foreach ($value as $ingredientInput) {
                    if (!preg_match('/^.+,\s*.+$/', $ingredientInput)) {
                        $fail('Каждый ингредиент должен быть в формате "название, единица измерения". Например: "Гречка, г".');
                    }
                }
            }],
            'quantities.*' => 'integer|min:1',
        ],
        [
            'name.required' => 'Поле обязательно для заполения.',
            'cooking_method.required' => 'Поле обязательно для заполения.',
            'cooking_time.required' => 'Поле обязательно для заполения.',
            'category_id.required' => 'Поле обязательно для заполения.',
            'ingredient_names.required' => 'Поле обязательно для заполения.',
            'quantities.required' => 'Поле обязательно для заполения.',
        ]);

        $dish = Dish::all()->where('id', $id)->first();

        $dish->name = $validated['name'];
        $dish->cooking_method = $validated['cooking_method'];
        $dish->cooking_time = $validated['cooking_time'];
        $dish->category_id = $validated['category_id'];
        $dish->save();

        $ingredientData = [];

        foreach ($validated['ingredient_names'] as $index => $ingredientInput) {
            $parts = explode(',', $ingredientInput);
            $ingredientName = trim($parts[0]);
            $ingredientUnit = isset($parts[1]) ? trim($parts[1]) : '';

            // Ищем ингредиент по имени и единице измерения
            $ingredient = Ingredient::where('name', $ingredientName)
                ->where('units', $ingredientUnit)
                ->first();

            // Если не найден, создаем новый ингредиент
            if (!$ingredient) {
                $ingredient = Ingredient::create([
                    'name' => $ingredientName,
                    'units' => $ingredientUnit,
                ]);
            }

            // Сохраняем количество ингредиента для связывания с блюдом
            $ingredientData[$ingredient->id] = ['quantity' => $validated['quantities'][$index]];
        }

        // Синхронизируем ингредиенты с блюдом (обновляем связь)
        $dish->ingredient()->sync($ingredientData);

//        // Обработка удаления фотографий
//        if ($request->has('photos_to_delete')) {
//            foreach ($request->input('photos_to_delete') as $photoId) {
//                $photo = Photo::find($photoId);
//                if ($photo) {
//                    Storage::disk('minio')->delete($photo->path); // Удаляем фото из MinIO
//                    $photo->delete(); // Удаляем запись из базы данных
//                }
//            }
//        }
//
//        // Обработка добавления новых фотографий
//        if ($request->hasFile('photos') || $dish->photo->count() > 0) {
//            foreach ($request->file('photos') as $photoFile) {
//                $path = $photoFile->store('photos', 'minio');
//
//                // Привязываем новую фотографию к блюду
//                $dish->photo()->create([
//                    'path' => $path
//                ]);
//            }
//        } else {
//            return back()->withErrors(['error' => 'Необходимо добавить хотя бы одну фотографию']);
//        }

        return redirect()->route('dish.show',['id'=> $dish->id])->withErrors('success', 'Блюдо обновлено успешно');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dish = Dish::findOrFail($id);

        foreach ($dish->photo as $photo) {
            Storage::disk('minio')->delete($photo->path);

            $photo->delete();
        }

        $dish->ingredient()->detach();

        $dish->delete();
        return redirect('/dish')->withErrors(['success'=>'Блюдо успешно удалено!']);
    }
}
