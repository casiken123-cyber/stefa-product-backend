<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public endpoints: guests may only register and log in
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Private endpoints (require a valid Sanctum token, otherwise 401)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return AuthController::safeAccount($request->user());
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Any signed-in account (user or admin) may list and view products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);

    // Customer-only
    Route::middleware('role:customer')->group(function () {
        Route::apiResource('orders', OrderController::class);
    });

    // Admin-only (a signed-in non-admin gets 403)
    Route::middleware('role:admin')->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        Route::apiResource('admins', AdminController::class);
        Route::apiResource('order-items', OrderItemController::class);
    });
});