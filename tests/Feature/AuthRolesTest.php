<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\ApiTestCase;

class AuthRolesTest extends ApiTestCase
{
    public function test_customer_login_returns_the_user_role(): void
    {
        $user = $this->makeUser();

        $this->postJson('/api/login', ['email' => $user->email, 'password' => 'password123'])
            ->assertOk()
            ->assertJsonPath('user.role', 'user')
            ->assertJsonStructure(['token']);
    }

    public function test_admin_login_returns_the_admin_role(): void
    {
        $admin = $this->makeAdmin();

        $this->postJson('/api/login', ['email' => $admin->email, 'password' => 'password123'])
            ->assertOk()
            ->assertJsonPath('user.role', 'admin')
            ->assertJsonStructure(['token']);
    }

    public function test_wrong_password_is_rejected(): void
    {
        $user = $this->makeUser();

        $this->postJson('/api/login', ['email' => $user->email, 'password' => 'not-the-password'])
            ->assertStatus(401);
    }

    public function test_registration_cannot_choose_the_admin_role(): void
    {
        $this->postJson('/api/register', [
            'name' => 'Sneaky Person',
            'email' => 'sneaky@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ])
            ->assertStatus(201)
            ->assertJsonPath('user.role', 'user');

        $this->assertDatabaseHas('users', ['email' => 'sneaky@example.com']);
    }

    public function test_guest_cannot_open_private_endpoints(): void
    {
        $this->getJson('/api/orders')->assertStatus(401);
        $this->getJson('/api/admin/stats')->assertStatus(401);
    }

    public function test_customer_cannot_use_admin_endpoints(): void
    {
        Sanctum::actingAs($this->makeUser(), ['*']);

        $this->getJson('/api/admin/stats')->assertStatus(403);
        $this->getJson('/api/admin/orders')->assertStatus(403);
    }

    public function test_admin_cannot_use_customer_endpoints(): void
    {
        Sanctum::actingAs($this->makeAdmin(), ['*']);

        $this->getJson('/api/orders')->assertStatus(403);
        $this->getJson('/api/profile')->assertStatus(403);
    }
}