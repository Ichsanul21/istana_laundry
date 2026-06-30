<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tips Laundry'],
            ['name' => 'Perawatan Pakaian'],
            ['name' => 'Berita'],
            ['name' => 'Promo'],
        ];

        foreach ($categories as $cat) {
            ArticleCategory::firstOrCreate(['name' => $cat['name']], $cat);
        }
    }
}
