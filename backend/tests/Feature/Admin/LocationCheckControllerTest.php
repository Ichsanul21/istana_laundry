<?php

namespace Tests\Feature\Admin;

use App\Models\LocationCheck;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationCheckControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_location_check_index_requires_authentication(): void
    {
        $response = $this->get(route('admin.location-checks.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_location_check_index_returns_view(): void
    {
        LocationCheck::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.location-checks.index'));

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.location-checks.index')
            ->assertViewHas('checks');
    }

    public function test_location_check_index_filters_by_status(): void
    {
        LocationCheck::factory()->withinRadius()->create();
        LocationCheck::factory()->outsideRadius()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.location-checks.index', ['status' => 'within']));

        $response->assertStatus(200);
        $checks = $response->viewData('checks');
        $this->assertEquals(1, $checks->count());
    }

    public function test_location_check_index_filters_by_search(): void
    {
        LocationCheck::factory()->create(['name' => 'John Doe']);
        LocationCheck::factory()->create(['name' => 'Jane Smith']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.location-checks.index', ['search' => 'John']));

        $response->assertStatus(200);
        $checks = $response->viewData('checks');
        $this->assertEquals(1, $checks->count());
    }

    public function test_location_check_show_returns_view(): void
    {
        $check = LocationCheck::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.location-checks.show', $check));

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.location-checks.show')
            ->assertViewHas('locationCheck');
    }

    public function test_location_check_export_returns_csv(): void
    {
        LocationCheck::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.location-checks.export'));

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'text/csv; charset=utf-8');
    }
}
