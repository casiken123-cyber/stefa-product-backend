<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Tests\ApiTestCase;

class StrapDetailsTest extends ApiTestCase
{
    private function strapPayload(array $override = []): array
    {
        return array_merge([
            'name' => 'Heritage Calfskin Strap',
            'description' => 'Hand-stitched calfskin strap.',
            'price' => 59.00,
            'stock' => 12,
            'category' => 'Calfskin',
            'lug_width' => 20,
            'leather_type' => 'Full-grain calfskin',
            'color' => 'Cognac brown',
            'buckle' => 'Brushed steel pin buckle',
            'length' => 'Standard',
            'quick_release' => true,
        ], $override);
    }

    public function test_admin_can_create_a_strap_with_its_details(): void
    {
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->postJson('/api/products', $this->strapPayload())
            ->assertStatus(201)
            ->assertJsonPath('data.lug_width', 20)
            ->assertJsonPath('data.leather_type', 'Full-grain calfskin')
            ->assertJsonPath('data.color', 'Cognac brown')
            ->assertJsonPath('data.buckle', 'Brushed steel pin buckle')
            ->assertJsonPath('data.length', 'Standard')
            ->assertJsonPath('data.quick_release', true);

        $this->assertDatabaseHas('products', [
            'name' => 'Heritage Calfskin Strap',
            'lug_width' => 20,
            'quick_release' => 1,
        ]);
    }

    public function test_a_product_without_strap_details_still_works(): void
    {
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->postJson('/api/products', [
            'name' => 'Plain Product',
            'price' => 10,
            'stock' => 3,
        ])
            ->assertStatus(201)
            ->assertJsonPath('data.lug_width', null)
            ->assertJsonPath('data.quick_release', false);
    }

    public function test_an_impossible_lug_width_is_rejected(): void
    {
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->postJson('/api/products', $this->strapPayload(['lug_width' => 99]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['lug_width']);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_admin_can_change_the_strap_details(): void
    {
        $product = $this->makeProduct(stock: 5);
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->putJson("/api/products/{$product->id}", [
            'lug_width' => 22,
            'color' => 'Espresso brown',
        ])
            ->assertOk()
            ->assertJsonPath('data.lug_width', 22)
            ->assertJsonPath('data.color', 'Espresso brown');
    }

    public function test_customers_see_the_strap_details_but_cannot_edit_them(): void
    {
        $product = $this->makeProduct(stock: 5);
        $product->update(['lug_width' => 18, 'leather_type' => 'Suede']);

        Sanctum::actingAs($this->makeUser(), ['*']);

        $this->getJson("/api/products/{$product->id}")
            ->assertOk()
            ->assertJsonPath('data.lug_width', 18)
            ->assertJsonPath('data.leather_type', 'Suede');

        $this->putJson("/api/products/{$product->id}", ['lug_width' => 24])->assertStatus(403);
    }
}