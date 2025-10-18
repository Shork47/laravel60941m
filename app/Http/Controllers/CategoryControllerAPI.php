<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response(Category::limit($request->perpage ?? 5)->
        offset(($request->perpage ?? 5) * ($request->page ?? 0))->get());
    }

    public function total()
    {
        return response(Category::all()->count());
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        if(!Gate::allows('category-create')) {
            return response()->json([
                'code' => 1,
                'message' => 'Нет прав для создания категории',
            ]);
        }
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $file = $request->file('image');
        $fileName = rand(1, 100000).'_'.$file->getClientOriginalName();
        try {
            $path = Storage::disk('s3')->putFileAs('category', $file, $fileName);
            $fileUrl = Storage::disk('s3')->url($path);
        }
        catch (Exception $e) {
            return response()->json([
                'code' => 2,
                'message' => 'Ошибка загрузки в хранилище',
            ]);
        };
        $category = new Category($validated);
        $category->photo_path = $fileUrl;
        $category->save();
        return response()->json([
            'code' => 0,
            'message' => 'Категория добавлена',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(Category::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
