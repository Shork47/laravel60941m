<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryControllerAPI;
use App\Http\Controllers\DishController;
use App\Http\Controllers\DishControllerAPI;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\IngredientControllerAPI;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DishController::class, 'index']);

Route::get('/hello', function () {
    return view('hello' ,['title' => 'Hello World!']);
});
Route::get('/category', [CategoryController::class, 'index']);

Route::get('/category/{id}', [CategoryController::class, 'show']);

Route::get('/dish', [DishController::class, 'index']);

Route::get('/dish/create', [DishController::class, 'create'])->middleware('auth');

Route::get('/dish/edit/{id}', [DishController::class, 'edit'])->middleware('auth');

Route::post('/dish/update/{id}', [DishController::class, 'update'])->middleware('auth');

Route::get('/dish/destroy/{id}', [DishController::class, 'destroy'])->middleware('auth');

Route::post('/dish', [DishController::class, 'store']);

Route::get('/dish/{id}', [DishController::class, 'show'])->name('dish.show');

Route::get('/ingredient/{id}', [IngredientController::class, 'show']);

Route::get('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout']);

Route::post('/auth', [LoginController::class, 'authenticate']);

Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::get('/error', function () {
    return view ('error', ['message' => session('message')]);
});

Route::get('/registration', [RegistrationController::class, 'registration']);

Route::post('/registration', [RegistrationController::class, 'register']);

////for API
//Route::prefix('api')->middleware('api')->group(function () {
//    Route::post('/login', [AuthController::class,'login']);
//
//    Route::apiResource('category', CategoryControllerAPI::class);
//    Route::apiResource('ingredient', IngredientControllerAPI::class);
//    Route::apiResource('dish', DishControllerAPI::class);
//});

