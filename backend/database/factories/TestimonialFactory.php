<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        return [
            'customer_name' => $this->faker->name(),
            'customer_title' => $this->faker->jobTitle(),
            'rating' => $this->faker->numberBetween(1, 5),
            'body' => $this->faker->paragraph(),
            'avatar' => null,
            'is_active' => true,
            'sort_order' => $this->faker->numberBetween(1, 10),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
