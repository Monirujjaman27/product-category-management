<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Route By api Resources
Route::apiResources(['category'  => CategoryController::class]); // 👉 :: category api ::
Route::apiResources(['product'  => ProductController::class]); // 👉 :: product api ::

Route::get('get-product-categories', [ProductController::class, 'get_product_categories']);
