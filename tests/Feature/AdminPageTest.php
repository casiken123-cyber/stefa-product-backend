<?php

namespace Tests\Feature;

use Tests\ApiTestCase;

class AdminPageTest extends ApiTestCase
{
    public function test_the_admin_page_is_never_cached_or_indexed(): void
    {
        $response = $this->get('/admin');

        $response->assertOk();
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_the_admin_data_stays_behind_the_api(): void
    {
        // The page itself carries no data; its endpoints refuse guests
        $this->getJson('/api/admin/stats')->assertStatus(401);
        $this->getJson('/api/admin/orders')->assertStatus(401);
        $this->getJson('/api/admin/users')->assertStatus(401);
    }
}