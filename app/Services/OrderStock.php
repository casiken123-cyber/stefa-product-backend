<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

// Keeps product stock in step with orders
class OrderStock
{
    // Lock the product, make sure enough is left, and take the quantity out of stock
    public static function take(int $productId, int $quantity): Product
    {
        $product = Product::whereKey($productId)->lockForUpdate()->firstOrFail();

        if ($product->stock < $quantity) {
            throw ValidationException::withMessages([
                'items' => ["Not enough stock for {$product->name}. Only {$product->stock} left."],
            ]);
        }

        $product->decrement('stock', $quantity);

        return $product;
    }

    // Put the items of an order back into stock
    public static function giveBack(Order $order): void
    {
        foreach ($order->items as $item) {
            Product::whereKey($item->product_id)->increment('stock', $item->quantity);
        }
    }

    // Take the items of an order out of stock again
    public static function takeAgain(Order $order): void
    {
        foreach ($order->items as $item) {
            self::take($item->product_id, $item->quantity);
        }
    }

    // Call this when an order's status changes: cancelling returns the items,
    // and re-opening a cancelled order takes them out again
    public static function onStatusChange(Order $order, string $from, string $to): void
    {
        if ($from === $to) {
            return;
        }

        if ($to === 'cancelled') {
            self::giveBack($order);
        } elseif ($from === 'cancelled') {
            self::takeAgain($order);
        }
    }
}
