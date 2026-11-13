<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/shop', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Product::query();

    if ($request->has('category')) {
        $query->where('category', $request->category);
    }

    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $products = $query->get();

    return view('shop', compact('products'));
});

Route::view('/login', 'login')->name('login');
Route::view('/register', 'register');

// Unlocked layout gates for frontend workflow simulation
Route::view('/cart', 'cart');
Route::view('/profile', 'profile');
Route::view('/checkout', 'order');
// Administration Management Module Gateway Route
Route::view('/admin', 'admin');

