<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $this->faker->paragraphs(5, true),
            'excerpt' => $this->faker->paragraph(),
            'featured_image' => null,
            'alt_text' => null,
            'category_id' => ArticleCategory::factory(),
            'author' => $this->faker->name(),
            'status' => 'draft',
            'published_at' => null,
            'meta_title' => null,
            'meta_description' => null,
            'og_title' => null,
            'og_description' => null,
            'og_image' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'scheduled',
            'published_at' => now()->addDay(),
        ]);
    }
}
