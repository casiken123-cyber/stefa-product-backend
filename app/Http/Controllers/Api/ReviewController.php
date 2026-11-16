<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Customer: the reviews this customer has already written
    public function mine(Request $request)
    {
        $reviews = Review::where('user_id', $request->user()->id)
            ->get(['product_id', 'rating', 'comment']);

        return response()->json(['data' => $reviews]);
    }

    // Customer: review a product from a completed order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $user = $request->user();

        $bought = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereHas('items', fn ($query) => $query->where('product_id', $validated['product_id']))
            ->exists();

        if (! $bought) {
            return response()->json([
                'message' => 'You can only review products from your completed orders.',
            ], 422);
        }

        if (Review::where('user_id', $user->id)->where('product_id', $validated['product_id'])->exists()) {
            return response()->json([
                'message' => 'You have already reviewed this product.',
            ], 422);
        }

        $review = Review::create($validated + ['user_id' => $user->id]);

        return response()->json(['data' => $this->format($review->load(['user', 'product']))], 201);
    }

    // Admin: every review
    public function adminIndex()
    {
        $reviews = Review::with(['user', 'product'])->latest()->get();

        return response()->json(['data' => $reviews->map(fn ($review) => $this->format($review))]);
    }

    // Admin: remove a review
    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json(['message' => 'Review deleted']);
    }

    private function format(Review $review): array
    {
        return [
            'id' => $review->id,
            'rating' => $review->rating,
            'comment' => $review->comment,
            'created_at' => $review->created_at,
            'customer' => $review->user ? [
                'id' => $review->user->id,
                'name' => $review->user->name,
                'email' => $review->user->email,
            ] : null,
            'product' => $review->product ? [
                'id' => $review->product->id,
                'name' => $review->product->name,
            ] : null,
        ];
    }
}
