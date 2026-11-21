<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AdminOrderController;
use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NoticeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public endpoints: guests may only register and log in
// At most 10 attempts per minute from one address, to slow down password guessing
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
Route::post('/forgot-password', [PasswordResetController::class, 'forgot'])->middleware('throttle:5,1');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->middleware('throttle:10,1');

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

        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::put('/profile/password', [ProfileController::class, 'password']);
        Route::post('/profile/avatar', [ProfileController::class, 'avatar']);
        Route::delete('/profile/avatar', [ProfileController::class, 'removeAvatar']);

        // Reviews: write, edit and delete your own
        Route::get('/reviews/mine', [ReviewController::class, 'mine']);
        Route::post('/reviews', [ReviewController::class, 'store']);
        Route::put('/reviews/{review}', [ReviewController::class, 'update']);
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);

        Route::get('/notices', [NoticeController::class, 'index']);
        Route::post('/notices/read', [NoticeController::class, 'readAll']);
        Route::delete('/notices/{notice}', [NoticeController::class, 'destroy']);
        Route::delete('/notices', [NoticeController::class, 'clear']);
    });

    // Admin-only (a signed-in non-admin gets 403)
    Route::middleware('role:admin')->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        Route::apiResource('admins', AdminController::class);
        Route::apiResource('order-items', OrderItemController::class);
        Route::apiResource('categories', CategoryController::class)->except(['show']);

        // Admin dashboard numbers and order management
        Route::get('/admin/stats', [AdminOrderController::class, 'stats']);
        Route::get('/admin/orders', [AdminOrderController::class, 'index']);
        Route::put('/admin/orders/{order}', [AdminOrderController::class, 'update']);
        Route::delete('/admin/orders/{order}', [AdminOrderController::class, 'destroy']);
        Route::post('/admin/orders/{order}/notify', [AdminOrderController::class, 'notify']);

        // User management and review moderation
        Route::get('/admin/users', [AdminUserController::class, 'index']);
        Route::put('/admin/users/{user}', [AdminUserController::class, 'update']);
        Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy']);
        Route::get('/admin/reviews', [ReviewController::class, 'adminIndex']);
        Route::delete('/admin/reviews/{review}', [ReviewController::class, 'destroy']);
    });
});