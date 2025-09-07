<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryControllerAPI;
use App\Http\Controllers\DishControllerAPI;
use App\Http\Controllers\IngredientControllerAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

//for API
Route::post('/login', [AuthController::class, 'login']);
Route::get('/category', [CategoryControllerAPI::class, 'index']);
Route::get('/category/{id}', [CategoryControllerAPI::class, 'show']);
//Route::get('/dish', [DishControllerAPI::class, 'index']);
Route::get('/dish/{id}', [DishControllerAPI::class, 'show']);
Route::get('/ingredient', [IngredientControllerAPI::class, 'index']);
Route::get('/ingredient/{id}', [IngredientControllerAPI::class, 'show']);

//2|MUpQrFkV64z71ACry2Af2kDMdRgArPYQx7xub3zYce2b8f56

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/dish', [DishControllerAPI::class, 'index']);// вот это мб надо будет убрать
    Route::get('/logout', [AuthController::class, 'logout']);
});
