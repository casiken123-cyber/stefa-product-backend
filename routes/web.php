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

    // Attach each product's reviews (written by customers with a completed order)
    $reviews = \App\Models\Review::with('user')->latest()->get()->groupBy('product_id');
    $products->each(fn ($product) => $product->setRelation('reviews', $reviews->get($product->id, collect())));

    return view('shop', compact('products'));
});

Route::view('/login', 'login')->name('login');
Route::redirect('/register', '/login');

// Unlocked layout gates for frontend workflow simulation
Route::view('/cart', 'cart');
Route::view('/profile', 'profile');
Route::view('/checkout', 'order');

// Administration Management Module Gateway Route.
// The page is only a shell (all data comes from the role-protected API), but it is
// never cached and never indexed, so the Back button after logout shows nothing.
Route::get('/admin', function () {
    return response()->view('admin')->withHeaders([
        'Cache-Control' => 'no-store, no-cache, must-revalidate',
        'X-Robots-Tag' => 'noindex, nofollow',
    ]);
});