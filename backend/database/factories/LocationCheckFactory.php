<?php

namespace Database\Factories;

use App\Models\LocationCheck;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationCheckFactory extends Factory
{
    protected $model = LocationCheck::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->optional()->email(),
            'whatsapp' => '08' . $this->faker->numerify('##########'),
            'address' => $this->faker->address(),
            'lat' => $this->faker->latitude(-0.55, -0.45),
            'lng' => $this->faker->longitude(117.05, 117.25),
            'nearest_branch_id' => Branch::factory(),
            'distance_km' => $this->faker->randomFloat(3, 0.5, 10),
            'is_within_radius' => $this->faker->boolean(70),
        ];
    }

    public function withinRadius(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_within_radius' => true,
            'distance_km' => $this->faker->randomFloat(3, 0.1, 2.9),
        ]);
    }

    public function outsideRadius(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_within_radius' => false,
            'distance_km' => $this->faker->randomFloat(3, 3.1, 15),
        ]);
    }
}
