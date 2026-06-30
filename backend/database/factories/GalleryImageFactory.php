<?php

namespace Database\Factories;

use App\Models\GalleryImage;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryImageFactory extends Factory
{
    protected $model = GalleryImage::class;

    public function definition(): array
    {
        return [
            'gallery_id' => Gallery::factory(),
            'image_path' => 'galleries/' . $this->faker->uuid() . '.jpg',
            'caption' => $this->faker->optional()->sentence(),
            'alt_text' => $this->faker->optional()->words(3, true),
            'sort_order' => $this->faker->numberBetween(0, 10),
        ];
    }
}
