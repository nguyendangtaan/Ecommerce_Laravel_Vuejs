<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\BrandsController;
use App\Http\Controllers\Api\CategoriesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('products', ProductsController::class);
Route::apiResource('brands', BrandsController::class);
Route::apiResource('categories', CategoriesController::class);