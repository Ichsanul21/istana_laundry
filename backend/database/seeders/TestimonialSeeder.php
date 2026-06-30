<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'customer_name' => 'Siti Rahmawati',
                'customer_title' => 'Ibu Rumah Tangga',
                'rating' => 5,
                'body' => 'Laundry favorit saya! Wanginya tahan lama, pengiriman tepat waktu, dan harga terjangkau. Sudah langganan lebih dari setahun.',
                'sort_order' => 1,
            ],
            [
                'customer_name' => 'Ahmad Fauzi',
                'customer_title' => 'Karyawan Swasta',
                'rating' => 5,
                'body' => 'Pelayanan express 6 jam-nya benar-benar membantu saat saya butuh pakaian cepat. Hasilnya rapi, wangi, dan tepat waktu.',
                'sort_order' => 2,
            ],
            [
                'customer_name' => 'Dewi Sartika',
                'customer_title' => 'Guru',
                'rating' => 5,
                'body' => 'Setrikaannya rapi banget! Cocok untuk pakaian seragam kerja yang butuh penampilan professional setiap hari.',
                'sort_order' => 3,
            ],
            [
                'customer_name' => 'Budi Hartono',
                'customer_title' => 'Mahasiswa',
                'rating' => 4,
                'body' => 'Harga ramah di kantong mahasiswa. Kualitas cucian bersih dan wangi. Lokasi strategis di dekat kampus.',
                'sort_order' => 4,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(['customer_name' => $t['customer_name']], $t);
        }
    }
}
