<?php

namespace Database\Factories;

use App\Models\CarpetInspection;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarpetInspectionFactory extends Factory
{
    protected $model = CarpetInspection::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'whatsapp' => '08'.$this->faker->numerify('##########'),
            'notes' => $this->faker->optional(0.6)->sentence(),
            'photo_path' => 'carpet-inspections/demo.jpg',
            'token' => $this->faker->unique()->regexify('[A-Za-z0-9]{32}'),
            'status' => 'completed',
            'overall_condition' => 'Sedang',
            'cleanliness_score' => $this->faker->numberBetween(40, 90),
            'findings' => [
                [
                    'label' => 'Noda',
                    'severity' => 'sedang',
                    'description' => 'Terdeteksi area noda yang cukup luas.',
                ],
                [
                    'label' => 'Keausan',
                    'severity' => 'ringan',
                    'description' => 'Beberapa serat terlihat mulai aus.',
                ],
            ],
            'recommendation' => 'Disarankan deep cleaning dengan metode wet extraction.',
            'summary' => 'Karpet dalam kondisi cukup baik namun perlu pembersihan menyeluruh.',
            'raw_response' => '{}',
            'error_message' => null,
        ];
    }

    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
            'overall_condition' => null,
            'cleanliness_score' => null,
            'findings' => null,
            'recommendation' => null,
            'summary' => null,
            'raw_response' => null,
            'error_message' => 'Layanan analisa sedang bermasalah. Silakan coba lagi.',
        ]);
    }

    public function processing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'processing',
            'overall_condition' => null,
            'cleanliness_score' => null,
            'findings' => null,
            'recommendation' => null,
            'summary' => null,
            'raw_response' => null,
        ]);
    }
}
