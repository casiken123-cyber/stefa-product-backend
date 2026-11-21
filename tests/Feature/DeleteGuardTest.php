<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\ApiTestCase;

class DeleteGuardTest extends ApiTestCase
{
    public function test_a_product_with_no_orders_can_be_deleted(): void
    {
        $product = $this->makeProduct(stock: 5);
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->deleteJson("/api/products/{$product->id}")->assertOk();

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_a_product_that_was_ordered_cannot_be_deleted(): void
    {
        $product = $this->makeProduct(stock: 5);
        $order = $this->makeOrder($this->makeUser(), $product, 1);
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->deleteJson("/api/products/{$product->id}")->assertStatus(422);

        // The product and the order line are both still there
        $this->assertDatabaseHas('products', ['id' => $product->id]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_a_product_in_a_cancelled_order_is_still_protected(): void
    {
        $product = $this->makeProduct(stock: 5);
        $this->makeOrder($this->makeUser(), $product, 1, 'cancelled');
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->deleteJson("/api/products/{$product->id}")->assertStatus(422);

        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    public function test_a_customer_cannot_delete_products(): void
    {
        $product = $this->makeProduct(stock: 5);
        Sanctum::actingAs($this->makeUser(), ['*']);

        $this->deleteJson("/api/products/{$product->id}")->assertStatus(403);

        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    public function test_a_user_with_orders_cannot_be_deleted(): void
    {
        $user = $this->makeUser();
        $this->makeOrder($user, $this->makeProduct(stock: 5), 1);
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->deleteJson("/api/admin/users/{$user->id}")->assertStatus(422);

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    public function test_a_user_without_orders_can_be_deleted(): void
    {
        $user = $this->makeUser();
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->deleteJson("/api/admin/users/{$user->id}")->assertOk();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}