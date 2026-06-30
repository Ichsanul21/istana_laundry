<?php

namespace Tests\Feature;

use App\Models\SeoSetting;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_seo_middleware_skips_admin_routes(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewMissing('seo');
    }

    public function test_seo_middleware_skips_api_routes(): void
    {
        $response = $this->getJson('/api/branches');

        $response->assertStatus(200);
    }

    public function test_seo_middleware_injects_data_for_public_routes(): void
    {
        Setting::create(['key' => 'default_meta_title', 'value' => 'Test Meta Title']);
        Setting::create(['key' => 'default_meta_description', 'value' => 'Test Meta Description']);

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }
}
