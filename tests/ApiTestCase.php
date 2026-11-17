<?php

namespace Tests;

use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

// Shared setup for the API feature tests.
abstract class ApiTestCase extends TestCase
{
    use RefreshDatabase;

    // SAFETY: RefreshDatabase wipes the database. Stop before that happens
    // unless the tests run on a throw-away in-memory SQLite database.
    protected function beforeRefreshingDatabase()
    {
        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");

        if ($connection !== 'sqlite' || $database !== ':memory:') {
            throw new RuntimeException(
                'Tests must use sqlite with :memory:. Check phpunit.xml (DB_CONNECTION and DB_DATABASE). '
                . "Current database: {$connection} / {$database}. Nothing was changed."
            );
        }
    }

    protected function makeUser(string $name = 'Test Buyer'): User
    {
        return User::forceCreate([
            'name' => $name,
            'email' => 'buyer' . uniqid() . '@example.com',
            'password' => Hash::make('password123'),
        ]);
    }

    protected function makeAdmin(): Admin
    {
        return Admin::forceCreate([
            'name' => 'Test Admin',
            'email' => 'admin' . uniqid() . '@example.com',
            'password' => Hash::make('password123'),
        ]);
    }

    protected function makeProduct(int $stock = 10, float $price = 100): Product
    {
        $name = 'Test Sneaker ' . uniqid();

        return Product::forceCreate([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => 'A product made for a test.',
            'price' => $price,
            'stock' => $stock,
            'category' => 'Sneakers',
        ]);
    }

    // The JSON body the shop sends to POST /api/orders
    protected function orderPayload(array $items, array $override = []): array
    {
        return array_merge([
            'items' => $items,
            'shipping_name' => 'Test Buyer',
            'shipping_phone' => '+639000000000',
            'shipping_address' => 'Zone 1, Test Street',
            'shipping_city' => 'Tagoloan',
            'shipping_zip' => '9001',
            'payment_method' => 'Cash on Delivery',
        ], $override);
    }

    // Builds an order directly in the database and takes its items out of stock,
    // the same way placing an order would. Use it for admin tests.
    protected function makeOrder(User $user, Product $product, int $quantity = 2, string $status = 'pending'): Order
    {
        $order = Order::forceCreate([
            'user_id' => $user->id,
            'status' => $status,
            'total' => $product->price * $quantity,
            'shipping_name' => 'Test Buyer',
            'shipping_phone' => '+639000000000',
            'shipping_address' => 'Zone 1, Test Street',
            'shipping_city' => 'Tagoloan',
            'shipping_zip' => '9001',
            'payment_method' => 'Cash on Delivery',
        ]);

        OrderItem::forceCreate([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price,
        ]);

        // A cancelled order has already returned its items to stock
        if ($status !== 'cancelled') {
            $product->decrement('stock', $quantity);
        }

        return $order;
    }

    protected function stockOf(Product $product): int
    {
        return (int) Product::find($product->id)->stock;
    }
}