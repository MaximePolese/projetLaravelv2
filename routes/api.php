<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/shops', [ShopController::class, 'store']);
    Route::put('/shops/{shop}', [ShopController::class, 'update']);
    Route::delete('/shops/{shop}', [ShopController::class, 'destroy']);

    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::put('/orders/{order}', [OrderController::class, 'update']);
    Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
});

Route::get('/csrf', function () {
    return csrf_token();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);

Route::get('/shops', [ShopController::class, 'index']);
Route::get('/shops/{shop}', [ShopController::class, 'show']);

Route::get('/products/sort', [ProductController::class, 'sortBy']);
Route::get('/products/filter', [ProductController::class, 'filterBy']);
Route::get('/products/search', [ProductController::class, 'searchBy']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);













