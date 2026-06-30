<?php

namespace Tests\Unit\Models;

use App\Models\Branch;
use App\Models\LocationCheck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchTest extends TestCase
{
    use RefreshDatabase;

    public function test_branch_has_location_checks_relationship(): void
    {
        $branch = Branch::factory()->create();
        $check = LocationCheck::factory()->create(['nearest_branch_id' => $branch->id]);

        $this->assertTrue($branch->locationChecks->contains($check));
    }

    public function test_active_scope_filters_inactive_branches(): void
    {
        Branch::factory()->create(['is_active' => true]);
        Branch::factory()->create(['is_active' => false]);

        $activeBranches = Branch::active()->get();

        $this->assertEquals(1, $activeBranches->count());
        $this->assertTrue($activeBranches->first()->is_active);
    }

    public function test_nearest_scope_returns_closest_branch(): void
    {
        $farBranch = Branch::factory()->create([
            'lat' => -0.55,
            'lng' => 117.20,
            'is_active' => true,
        ]);

        $nearBranch = Branch::factory()->create([
            'lat' => -0.487,
            'lng' => 117.129,
            'is_active' => true,
        ]);

        $nearest = Branch::nearest(-0.4869703, 117.1292781);

        $this->assertEquals($nearBranch->id, $nearest->id);
        $this->assertLessThan(1, $nearest->distance);
    }

    public function test_within_radius_scope_filters_by_distance(): void
    {
        $nearBranch = Branch::factory()->create([
            'lat' => -0.487,
            'lng' => 117.129,
            'radius_km' => 3,
            'is_active' => true,
        ]);

        $farBranch = Branch::factory()->create([
            'lat' => -0.55,
            'lng' => 117.20,
            'radius_km' => 3,
            'is_active' => true,
        ]);

        $withinRadius = Branch::withinRadius(-0.4869703, 117.1292781, 3);

        $this->assertEquals(1, $withinRadius->count());
        $this->assertEquals($nearBranch->id, $withinRadius->first()->id);
    }

    public function test_branch_casts_coordinates_correctly(): void
    {
        $branch = Branch::factory()->create([
            'lat' => -0.4869703,
            'lng' => 117.1292781,
            'radius_km' => 3.5,
            'is_active' => true,
        ]);

        $branch->refresh();

        $this->assertIsNumeric($branch->lat);
        $this->assertIsNumeric($branch->lng);
        $this->assertIsNumeric($branch->radius_km);
        $this->assertIsBool($branch->is_active);
    }

    public function test_branch_soft_deletes(): void
    {
        $branch = Branch::factory()->create();
        $branch->delete();

        $this->assertSoftDeleted($branch);
        $this->assertNull(Branch::find($branch->id));
        $this->assertNotNull(Branch::withTrashed()->find($branch->id));
    }
}
