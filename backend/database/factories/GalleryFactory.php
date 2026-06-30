<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GalleryFactory extends Factory
{
    protected $model = Gallery::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->words(2, true);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->optional()->paragraph(),
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
