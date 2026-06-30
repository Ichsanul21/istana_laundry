<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@istanalaundry.com'],
            [
                'name' => 'Admin Istana Laundry',
                'password' => bcrypt('password'),
            ],
        );

        $this->call([
            BranchSeeder::class,
            ArticleCategorySeeder::class,
            ServiceSeeder::class,
            TestimonialSeeder::class,
            FaqSeeder::class,
            PromotionSeeder::class,
            GallerySeeder::class,
            SettingSeeder::class,
        ]);
    }
}
