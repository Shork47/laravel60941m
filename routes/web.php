<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\IngredientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello', function () {
    return view('hello' ,['title' => 'Hello World!']);
});
Route::get('/category', [CategoryController::class, 'index']);

Route::get('/category/{id}', [CategoryController::class, 'show']);

Route::get('/dish', [DishController::class, 'index']);

Route::get('/dish/{id}', [DishController::class, 'show']);

Route::get('/ingredient/{id}', [IngredientController::class, 'show']);
