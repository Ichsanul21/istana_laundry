<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_returns_200(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_dashboard_redirects_to_admin(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_sitemap_returns_xml(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/xml');
    }

    public function test_robots_returns_text(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function test_robots_contains_sitemap_reference(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertSee('Sitemap:');
        $response->assertSee('sitemap.xml');
    }

    public function test_robots_disallows_admin(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertSee('Disallow: /admin');
    }

    public function test_admin_dashboard_requires_authentication(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_dashboard_returns_view(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard'));

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.dashboard');
    }
}
