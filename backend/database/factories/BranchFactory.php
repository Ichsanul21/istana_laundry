<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    protected $model = Branch::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Cabang',
            'type' => $this->faker->randomElement(['workshop', 'cabang']),
            'address' => $this->faker->address(),
            'lat' => $this->faker->latitude(-0.55, -0.45),
            'lng' => $this->faker->longitude(117.05, 117.25),
            'radius_km' => 3.00,
            'phone' => $this->faker->optional()->phoneNumber(),
            'is_active' => true,
            'open_hours' => '08:00 - 20:00',
            'sort_order' => $this->faker->numberBetween(1, 10),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function workshop(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'workshop',
        ]);
    }

    public function cabang(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'cabang',
        ]);
    }
}
