<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;



// Route By api Resources
Route::apiResources(['category'  => CategoryController::class]); // 👉 :: category api ::
Route::apiResources(['product'  => ProductController::class]); // 👉 :: product api ::

Route::get('get-product-categories', [ProductController::class, 'get_product_categories']);
