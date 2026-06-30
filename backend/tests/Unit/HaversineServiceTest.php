<?php

namespace Tests\Unit;

use App\Services\HaversineService;
use Tests\TestCase;

class HaversineServiceTest extends TestCase
{
    public function test_distance_between_same_point_is_zero(): void
    {
        $distance = HaversineService::distance(-0.4869703, 117.1292781, -0.4869703, 117.1292781);
        $this->assertEquals(0, $distance);
    }

    public function test_distance_between_known_points(): void
    {
        $branch1 = ['lat' => -0.4869703, 'lng' => 117.1292781];
        $branch2 = ['lat' => -0.4798972, 'lng' => 117.1468532];

        $distance = HaversineService::distance(
            $branch1['lat'], $branch1['lng'],
            $branch2['lat'], $branch2['lng']
        );

        $this->assertGreaterThan(1.5, $distance);
        $this->assertLessThan(2.5, $distance);
    }

    public function test_distance_is_symmetric(): void
    {
        $distance1 = HaversineService::distance(-0.4869703, 117.1292781, -0.4798972, 117.1468532);
        $distance2 = HaversineService::distance(-0.4798972, 117.1468532, -0.4869703, 117.1292781);

        $this->assertEqualsWithDelta($distance1, $distance2, 0.001);
    }

    public function test_distance_returns_positive_value(): void
    {
        $distance = HaversineService::distance(-0.5, 117.1, -0.4, 117.2);
        $this->assertGreaterThan(0, $distance);
    }
}
