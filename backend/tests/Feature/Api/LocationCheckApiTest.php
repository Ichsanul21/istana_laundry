<?php

namespace Tests\Feature\Api;

use App\Models\Branch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationCheckApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_location_check_returns_within_radius(): void
    {
        $branch = Branch::factory()->create([
            'lat' => -0.4869703,
            'lng' => 117.1292781,
            'radius_km' => 3,
            'is_active' => true,
        ]);

        $response = $this->postJson('/api/location/check', [
            'name' => 'Test User',
            'whatsapp' => '081234567890',
            'address' => 'Jl. Test No. 123',
            'lat' => -0.487,
            'lng' => 117.129,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'is_within_radius' => true,
                ],
            ])
            ->assertJsonStructure([
                'data' => [
                    'is_within_radius',
                    'distance_km',
                    'nearest_branch' => [
                        'id', 'name', 'address', 'phone', 'radius_km',
                    ],
                ],
            ]);
    }

    public function test_location_check_returns_outside_radius(): void
    {
        $branch = Branch::factory()->create([
            'lat' => -0.4869703,
            'lng' => 117.1292781,
            'radius_km' => 3,
            'is_active' => true,
        ]);

        $response = $this->postJson('/api/location/check', [
            'name' => 'Test User',
            'whatsapp' => '081234567890',
            'address' => 'Jl. Far Away',
            'lat' => -0.55,
            'lng' => 117.25,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'is_within_radius' => false,
                ],
            ]);
    }

    public function test_location_check_validates_required_fields(): void
    {
        $response = $this->postJson('/api/location/check', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'whatsapp', 'address', 'lat', 'lng']);
    }

    public function test_location_check_validates_coordinate_ranges(): void
    {
        $response = $this->postJson('/api/location/check', [
            'name' => 'Test User',
            'whatsapp' => '081234567890',
            'address' => 'Jl. Test',
            'lat' => 100,
            'lng' => 200,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['lat', 'lng']);
    }

    public function test_location_check_stores_record_in_database(): void
    {
        $branch = Branch::factory()->create([
            'lat' => -0.487,
            'lng' => 117.129,
            'radius_km' => 3,
            'is_active' => true,
        ]);

        $this->postJson('/api/location/check', [
            'name' => 'Test User',
            'whatsapp' => '081234567890',
            'address' => 'Jl. Test No. 123',
            'lat' => -0.487,
            'lng' => 117.129,
        ]);

        $this->assertDatabaseHas('location_checks', [
            'name' => 'Test User',
            'whatsapp' => '081234567890',
            'nearest_branch_id' => $branch->id,
        ]);
    }

    public function test_location_check_accepts_optional_email(): void
    {
        $branch = Branch::factory()->create([
            'lat' => -0.487,
            'lng' => 117.129,
            'radius_km' => 3,
            'is_active' => true,
        ]);

        $response = $this->postJson('/api/location/check', [
            'name' => 'Test User',
            'whatsapp' => '081234567890',
            'address' => 'Jl. Test',
            'lat' => -0.487,
            'lng' => 117.129,
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('location_checks', [
            'email' => 'test@example.com',
        ]);
    }
}
