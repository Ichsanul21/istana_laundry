<?php

namespace Tests\Feature\Api;

use App\Models\Branch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_branches_returns_active_branches(): void
    {
        $activeBranch = Branch::factory()->create(['is_active' => true]);
        $inactiveBranch = Branch::factory()->create(['is_active' => false]);

        $response = $this->getJson('/api/branches');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'name', 'type', 'address', 'lat', 'lng',
                        'radius_km', 'phone', 'open_hours',
                    ],
                ],
            ]);

        $data = $response->json('data');
        $this->assertEquals(1, count($data));
        $this->assertEquals($activeBranch->id, $data[0]['id']);
    }

    public function test_get_branches_returns_empty_array_when_no_branches(): void
    {
        $response = $this->getJson('/api/branches');

        $response->assertStatus(200)
            ->assertJson(['data' => []]);
    }

    public function test_get_branches_ordered_by_sort_order(): void
    {
        $branch2 = Branch::factory()->create(['sort_order' => 2, 'is_active' => true]);
        $branch1 = Branch::factory()->create(['sort_order' => 1, 'is_active' => true]);

        $response = $this->getJson('/api/branches');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(2, $data);
        $this->assertEquals($branch1->id, $data[0]['id']);
        $this->assertEquals($branch2->id, $data[1]['id']);
    }
}
