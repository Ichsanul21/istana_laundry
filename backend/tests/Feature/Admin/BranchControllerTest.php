<?php

namespace Tests\Feature\Admin;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'email' => 'admin@istanalaundry.com',
        ]);
    }

    public function test_branch_index_requires_authentication(): void
    {
        $response = $this->get(route('admin.branches.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_branch_index_returns_view(): void
    {
        Branch::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.branches.index'));

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.branches.index')
            ->assertViewHas('branches');
    }

    public function test_branch_create_returns_view(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.branches.create'));

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.branches.form');
    }

    public function test_branch_store_validates_data(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.branches.store'), []);

        $response->assertSessionHasErrors(['name', 'type', 'address', 'lat', 'lng', 'radius_km']);
    }

    public function test_branch_store_creates_branch(): void
    {
        $data = [
            'name' => 'Test Branch',
            'type' => 'cabang',
            'address' => 'Jl. Test No. 123',
            'lat' => -0.4869703,
            'lng' => 117.1292781,
            'radius_km' => 3,
            'phone' => '081234567890',
            'is_active' => true,
            'open_hours' => '08:00 - 20:00',
            'sort_order' => 1,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.branches.store'), $data);

        $response->assertRedirect(route('admin.branches.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('branches', [
            'name' => 'Test Branch',
            'type' => 'cabang',
        ]);
    }

    public function test_branch_edit_returns_view(): void
    {
        $branch = Branch::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.branches.edit', $branch));

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.branches.form')
            ->assertViewHas('branch');
    }

    public function test_branch_update_validates_data(): void
    {
        $branch = Branch::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.branches.update', $branch), []);

        $response->assertSessionHasErrors(['name', 'type', 'address', 'lat', 'lng', 'radius_km']);
    }

    public function test_branch_update_updates_branch(): void
    {
        $branch = Branch::factory()->create();

        $data = [
            'name' => 'Updated Branch Name',
            'type' => 'workshop',
            'address' => 'Jl. Updated Address',
            'lat' => -0.49,
            'lng' => 117.13,
            'radius_km' => 5,
            'is_active' => false,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.branches.update', $branch), $data);

        $response->assertRedirect(route('admin.branches.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('branches', [
            'id' => $branch->id,
            'name' => 'Updated Branch Name',
            'type' => 'workshop',
        ]);
    }

    public function test_branch_destroy_deletes_branch(): void
    {
        $branch = Branch::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.branches.destroy', $branch));

        $response->assertRedirect(route('admin.branches.index'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted('branches', ['id' => $branch->id]);
    }
}
