<?php

namespace Database\Factories;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PromotionFactory extends Factory
{
    protected $model = Promotion::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->words(3, true);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'image' => null,
            'discount_type' => $this->faker->randomElement(['percent', 'fixed']),
            'discount_value' => $this->faker->randomFloat(2, 5, 50),
            'start_date' => now()->subDay(),
            'end_date' => now()->addDays(30),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->subDays(60),
            'end_date' => now()->subDay(),
        ]);
    }
}
