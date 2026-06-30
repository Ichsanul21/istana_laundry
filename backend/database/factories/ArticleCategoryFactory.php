<?php

namespace Database\Factories;

use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleCategoryFactory extends Factory
{
    protected $model = ArticleCategory::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
