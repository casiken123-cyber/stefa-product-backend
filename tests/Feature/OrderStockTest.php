<?php

namespace Tests\Feature;

use App\Models\Order;
use Laravel\Sanctum\Sanctum;
use Tests\ApiTestCase;

class OrderStockTest extends ApiTestCase
{
    public function test_placing_an_order_takes_the_items_out_of_stock(): void
    {
        $user = $this->makeUser();
        $product = $this->makeProduct(stock: 5, price: 100);
        Sanctum::actingAs($user, ['*']);

        $this->postJson('/api/orders', $this->orderPayload([
            ['product_id' => $product->id, 'quantity' => 2],
        ]))->assertSuccessful();

        $this->assertSame(3, $this->stockOf($product));
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => 'pending',
            'total' => 200,
        ]);
    }

    public function test_cannot_order_more_than_the_stock(): void
    {
        $product = $this->makeProduct(stock: 2);
        Sanctum::actingAs($this->makeUser(), ['*']);

        $this->postJson('/api/orders', $this->orderPayload([
            ['product_id' => $product->id, 'quantity' => 3],
        ]))->assertStatus(422);

        $this->assertSame(2, $this->stockOf($product));
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_the_same_product_listed_twice_is_added_up(): void
    {
        $product = $this->makeProduct(stock: 3);
        Sanctum::actingAs($this->makeUser(), ['*']);

        // 2 + 2 = 4, but only 3 are in stock
        $this->postJson('/api/orders', $this->orderPayload([
            ['product_id' => $product->id, 'quantity' => 2],
            ['product_id' => $product->id, 'quantity' => 2],
        ]))->assertStatus(422);

        $this->assertSame(3, $this->stockOf($product));
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_an_order_without_shipping_details_is_rejected(): void
    {
        $product = $this->makeProduct(stock: 5);
        Sanctum::actingAs($this->makeUser(), ['*']);

        $this->postJson('/api/orders', [
            'items' => [['product_id' => $product->id, 'quantity' => 1]],
            'payment_method' => 'Cash on Delivery',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'shipping_name',
                'shipping_phone',
                'shipping_address',
                'shipping_city',
                'shipping_zip',
            ]);

        $this->assertSame(5, $this->stockOf($product));
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_only_cash_on_delivery_is_accepted(): void
    {
        $product = $this->makeProduct(stock: 5);
        Sanctum::actingAs($this->makeUser(), ['*']);

        $this->postJson('/api/orders', $this->orderPayload(
            [['product_id' => $product->id, 'quantity' => 1]],
            ['payment_method' => 'Credit Card']
        ))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['payment_method']);

        $this->assertSame(5, $this->stockOf($product));
    }

    public function test_customer_cancel_returns_the_stock_exactly_once(): void
    {
        $user = $this->makeUser();
        $product = $this->makeProduct(stock: 5);
        Sanctum::actingAs($user, ['*']);

        $this->postJson('/api/orders', $this->orderPayload([
            ['product_id' => $product->id, 'quantity' => 2],
        ]))->assertSuccessful();

        $order = Order::first();
        $this->assertSame(3, $this->stockOf($product));

        // First cancel returns the items
        $this->putJson("/api/orders/{$order->id}", ['status' => 'cancelled'])->assertOk();
        $this->assertSame(5, $this->stockOf($product));

        // A second cancel is refused and must not add stock again
        $this->putJson("/api/orders/{$order->id}", ['status' => 'cancelled'])->assertStatus(422);
        $this->assertSame(5, $this->stockOf($product));
    }

    public function test_customer_cannot_cancel_a_delivered_order(): void
    {
        $user = $this->makeUser();
        $product = $this->makeProduct(stock: 5);
        $order = $this->makeOrder($user, $product, 2, 'completed');
        Sanctum::actingAs($user, ['*']);

        $this->putJson("/api/orders/{$order->id}", ['status' => 'cancelled'])->assertStatus(422);

        $this->assertSame(3, $this->stockOf($product));
        $this->assertSame('completed', $order->fresh()->status);
    }

    public function test_customer_cannot_mark_an_order_as_delivered(): void
    {
        $user = $this->makeUser();
        $product = $this->makeProduct(stock: 5);
        $order = $this->makeOrder($user, $product, 1);
        Sanctum::actingAs($user, ['*']);

        $this->putJson("/api/orders/{$order->id}", ['status' => 'completed'])->assertStatus(422);

        $this->assertSame('pending', $order->fresh()->status);
    }

    public function test_customer_cannot_touch_another_customers_order(): void
    {
        $owner = $this->makeUser('Owner');
        $product = $this->makeProduct(stock: 5);
        $order = $this->makeOrder($owner, $product, 1);

        Sanctum::actingAs($this->makeUser('Someone Else'), ['*']);

        $this->getJson("/api/orders/{$order->id}")->assertStatus(403);
        $this->putJson("/api/orders/{$order->id}", ['status' => 'cancelled'])->assertStatus(403);
        $this->deleteJson("/api/orders/{$order->id}")->assertStatus(403);

        $this->assertSame('pending', $order->fresh()->status);
        $this->assertSame(4, $this->stockOf($product));
    }
}