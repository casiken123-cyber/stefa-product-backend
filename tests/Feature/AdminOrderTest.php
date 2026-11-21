<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\ApiTestCase;

class AdminOrderTest extends ApiTestCase
{
    public function test_admin_cancel_returns_the_stock(): void
    {
        $user = $this->makeUser();
        $product = $this->makeProduct(stock: 5);
        $order = $this->makeOrder($user, $product, 2); // stock is now 3
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->putJson("/api/admin/orders/{$order->id}", ['status' => 'cancelled'])->assertOk();

        $this->assertSame(5, $this->stockOf($product));
        $this->assertSame('cancelled', $order->fresh()->status);
        $this->assertDatabaseHas('notices', ['order_id' => $order->id, 'user_id' => $user->id]);
    }

    public function test_completing_an_order_does_not_change_the_stock(): void
    {
        $product = $this->makeProduct(stock: 5);
        $order = $this->makeOrder($this->makeUser(), $product, 2); // stock is now 3
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->putJson("/api/admin/orders/{$order->id}", ['status' => 'completed'])->assertOk();

        $this->assertSame(3, $this->stockOf($product));
    }

    public function test_a_delivered_order_is_locked(): void
    {
        $product = $this->makeProduct(stock: 5);
        $order = $this->makeOrder($this->makeUser(), $product, 2, 'completed');
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->putJson("/api/admin/orders/{$order->id}", ['status' => 'cancelled'])->assertStatus(422);
        $this->putJson("/api/admin/orders/{$order->id}", ['status' => 'pending'])->assertStatus(422);

        $this->assertSame('completed', $order->fresh()->status);
        $this->assertSame(3, $this->stockOf($product));
    }

    public function test_a_cancelled_order_is_locked(): void
    {
        $product = $this->makeProduct(stock: 5);
        $order = $this->makeOrder($this->makeUser(), $product, 2, 'cancelled'); // stock stays 5
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->putJson("/api/admin/orders/{$order->id}", ['status' => 'pending'])->assertStatus(422);

        $this->assertSame('cancelled', $order->fresh()->status);
        $this->assertSame(5, $this->stockOf($product));
    }

    public function test_an_order_cannot_go_back_to_pending(): void
    {
        $product = $this->makeProduct(stock: 5);
        $order = $this->makeOrder($this->makeUser(), $product, 1, 'processing');
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->putJson("/api/admin/orders/{$order->id}", ['status' => 'pending'])->assertStatus(422);

        $this->assertSame('processing', $order->fresh()->status);
    }

    public function test_only_cancelled_orders_can_be_deleted(): void
    {
        $user = $this->makeUser();
        $product = $this->makeProduct(stock: 10);
        $pending = $this->makeOrder($user, $product, 1);
        $cancelled = $this->makeOrder($user, $product, 1, 'cancelled');
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->deleteJson("/api/admin/orders/{$pending->id}")->assertStatus(422);
        $this->assertDatabaseHas('orders', ['id' => $pending->id]);

        $stockBefore = $this->stockOf($product);

        $this->deleteJson("/api/admin/orders/{$cancelled->id}")->assertOk();
        $this->assertDatabaseMissing('orders', ['id' => $cancelled->id]);

        // Deleting a cancelled order must not touch the stock
        $this->assertSame($stockBefore, $this->stockOf($product));
    }

    public function test_cancelling_twice_from_both_sides_returns_stock_only_once(): void
    {
        $user = $this->makeUser();
        $product = $this->makeProduct(stock: 5);
        $order = $this->makeOrder($user, $product, 2); // stock is now 3

        // The admin cancels first
        Sanctum::actingAs($this->makeAdmin(), ['*']);
        $this->putJson("/api/admin/orders/{$order->id}", ['status' => 'cancelled'])->assertOk();
        $this->assertSame(5, $this->stockOf($product));

        // Then the customer tries to cancel the same order
        $this->app['auth']->forgetGuards();
        Sanctum::actingAs($user, ['*']);
        $this->putJson("/api/orders/{$order->id}", ['status' => 'cancelled'])->assertStatus(422);

        $this->assertSame(5, $this->stockOf($product));
    }
}