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
        $reviews = Review::with('product:id,name')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get()
            ->map(fn ($review) => [
                'id' => $review->id,
                'order_id' => $review->order_id,
                'product_id' => $review->product_id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at,
                'updated_at' => $review->updated_at,
                'product' => $review->product ? [
                    'id' => $review->product->id,
                    'name' => $review->product->name,
                ] : null,
            ]);

        return response()->json(['data' => $reviews]);
    }

    // Customer: review a product from a completed order.
    // Each purchase (order + product) can be reviewed once, so buying the same
    // product again opens a new review. Without an order_id, the oldest
    // purchase that has not been reviewed yet is used.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'nullable|integer|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $user = $request->user();
        $productId = $validated['product_id'];

        $orders = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereHas('items', fn ($query) => $query->where('product_id', $productId))
            ->when(! empty($validated['order_id']), fn ($query) => $query->where('id', $validated['order_id']))
            ->orderBy('id')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'message' => 'You can only review products from your completed orders.',
            ], 422);
        }

        $reviewedOrderIds = Review::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->pluck('order_id')
            ->all();

        $order = $orders->first(fn ($candidate) => ! in_array($candidate->id, $reviewedOrderIds));

        if (! $order) {
            return response()->json([
                'message' => 'You have already reviewed this purchase.',
            ], 422);
        }

        $review = Review::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'product_id' => $productId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return response()->json(['data' => $this->format($review->load(['user', 'product']))], 201);
    }

    // Customer: edit one of their own reviews
    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'You can only edit your own reviews.',
            ], 403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update($validated);

        return response()->json(['data' => $this->format($review->load(['user', 'product']))]);
    }

    // Admin: every review
    public function adminIndex()
    {
        $reviews = Review::with(['user', 'product'])->latest()->get();

        return response()->json(['data' => $reviews->map(fn ($review) => $this->format($review))]);
    }

    // Customer: delete their own review. Admin: delete any review.
    public function destroy(Request $request, Review $review)
    {
        $user = $request->user();

        if ($user->role !== 'admin' && $review->user_id !== $user->id) {
            return response()->json([
                'message' => 'You can only delete your own reviews.',
            ], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted']);
    }

    private function format(Review $review): array
    {
        return [
            'id' => $review->id,
            'order_id' => $review->order_id,
            'user_id' => $review->user_id,
            'rating' => $review->rating,
            'comment' => $review->comment,
            'created_at' => $review->created_at,
            'updated_at' => $review->updated_at,
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