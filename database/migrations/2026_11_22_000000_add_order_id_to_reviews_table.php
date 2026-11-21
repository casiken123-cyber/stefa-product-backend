<?php

use App\Models\Order;
use App\Models\Review;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable()->after('product_id')->constrained()->nullOnDelete();
        });

        // Link each existing review to the oldest completed order of that customer that contains the product
        Review::whereNull('order_id')->orderBy('id')->get()->each(function ($review) {
            $usedOrderIds = Review::where('user_id', $review->user_id)
                ->where('product_id', $review->product_id)
                ->whereNotNull('order_id')
                ->pluck('order_id');

            $order = Order::where('user_id', $review->user_id)
                ->where('status', 'completed')
                ->whereHas('items', fn ($query) => $query->where('product_id', $review->product_id))
                ->whereNotIn('id', $usedOrderIds)
                ->orderBy('id')
                ->first();

            if ($order) {
                $review->order_id = $order->id;
                $review->saveQuietly();
            }
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropConstrainedForeignId('order_id');
        });
    }
};