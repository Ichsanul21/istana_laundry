<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $gallery = Gallery::firstOrCreate(
            ['title' => 'Kegiatan Operasional'],
            [
                'description' => 'Dokumentasi kegiatan sehari-hari di Istana Laundry.',
                'sort_order' => 1,
            ]
        );

        $images = [
            ['image_path' => 'galleries/operasional-1.jpg', 'caption' => 'Proses pencucian dengan mesin modern', 'sort_order' => 1],
            ['image_path' => 'galleries/operasional-2.jpg', 'caption' => 'Setrika uap profesional', 'sort_order' => 2],
            ['image_path' => 'galleries/operasional-3.jpg', 'caption' => 'Penataan pakaian siap antar', 'sort_order' => 3],
        ];

        foreach ($images as $img) {
            $gallery->images()->firstOrCreate(
                ['image_path' => $img['image_path']],
                $img,
            );
        }

        Gallery::firstOrCreate(
            ['title' => 'Outlet Kami'],
            [
                'description' => 'Suasana outlet Istana Laundry.',
                'sort_order' => 2,
            ]
        );
    }
}
