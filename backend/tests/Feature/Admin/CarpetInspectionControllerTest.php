<?php

namespace Tests\Feature\Admin;

use App\Models\CarpetInspection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarpetInspectionControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_index_requires_authentication(): void
    {
        $response = $this->get(route('admin.carpet-inspections.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_index_returns_view(): void
    {
        CarpetInspection::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.carpet-inspections.index'));

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.carpet-inspections.index')
            ->assertViewHas('inspections');
    }

    public function test_index_filters_by_status(): void
    {
        CarpetInspection::factory()->create();
        CarpetInspection::factory()->failed()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.carpet-inspections.index', ['status' => 'failed']));

        $response->assertStatus(200);
        $this->assertEquals(1, $response->viewData('inspections')->count());
    }

    public function test_index_filters_by_search(): void
    {
        CarpetInspection::factory()->create(['name' => 'John Doe']);
        CarpetInspection::factory()->create(['name' => 'Jane Smith']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.carpet-inspections.index', ['search' => 'John']));

        $response->assertStatus(200);
        $this->assertEquals(1, $response->viewData('inspections')->count());
    }

    public function test_index_filters_by_condition(): void
    {
        CarpetInspection::factory()->create(['overall_condition' => 'Baik']);
        CarpetInspection::factory()->create(['overall_condition' => 'Buruk']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.carpet-inspections.index', ['condition' => 'Baik']));

        $response->assertStatus(200);
        $this->assertEquals(1, $response->viewData('inspections')->count());
    }

    public function test_show_returns_view(): void
    {
        $inspection = CarpetInspection::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.carpet-inspections.show', $inspection));

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.carpet-inspections.show')
            ->assertViewHas('inspection');
    }
}
