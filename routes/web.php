<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::post('/signUp', [AuthController::class, 'signUp']);

    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::prefix('categories')->group(function () {
    Route::get('', [CategoryController::class, 'index']);

    Route::post('', [CategoryController::class, 'store']);

    Route::get('/{id}', [CategoryController::class, 'show']);

    Route::delete('/{id}', [CategoryController::class, 'destroy']);

    Route::patch('/{id}', [CategoryController::class, 'update']);

    Route::get('/{id}/products', [CategoryController::class, 'showProducts']);
});


Route::prefix('products')->group(function () {
    Route::get('', [ProductController::class, 'index']);

    Route::post('', [ProductController::class, 'store']);
});
