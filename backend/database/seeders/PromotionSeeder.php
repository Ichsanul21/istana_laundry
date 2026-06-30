<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $promotions = [
            [
                'title' => 'Promo Laundry 5 kg',
                'description' => 'Cuci kering + setrika 5 kg hanya Rp50.000! Hemat hingga Rp10.000. Promo berlaku untuk pelanggan baru.',
                'discount_type' => 'fixed',
                'discount_value' => 10000,
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(25),
            ],
            [
                'title' => 'Diskon Pelajar 15%',
                'description' => 'Tunjukkan kartu pelajar/mahasiswa dan dapatkan diskon 15% untuk semua layanan.',
                'discount_type' => 'percent',
                'discount_value' => 15,
                'start_date' => now()->subMonth(),
                'end_date' => now()->addMonths(2),
            ],
            [
                'title' => 'Laundry Gratis Ongkir',
                'description' => 'Gratis antar-jemput untuk area Samarinda Ulu dan Samarinda Kota dengan minimal 3 kg.',
                'discount_type' => 'fixed',
                'discount_value' => 5000,
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(20),
            ],
        ];

        foreach ($promotions as $promo) {
            Promotion::firstOrCreate(['title' => $promo['title']], $promo);
        }
    }
}
