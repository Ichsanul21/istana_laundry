<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Cuci Kering',
                'description' => 'Cuci dengan mesin berkualitas, deterjen pilihan, dan dikeringkan dengan sempurna. Siap pakai dalam waktu singkat.',
                'price' => 7000,
                'unit' => 'kg',
                'icon' => 'washing-machine',
                'sort_order' => 1,
            ],
            [
                'name' => 'Cuci Setrika',
                'description' => 'Layanan cuci + setrika lengkap. Pakaian bersih, wangi, dan rapi tanpa perlu disetrika ulang.',
                'price' => 12000,
                'unit' => 'kg',
                'icon' => 'iron',
                'sort_order' => 2,
            ],
            [
                'name' => 'Setrika Saja',
                'description' => 'Khusus untuk pakaian yang sudah dicuci, kami setrika hingga rapi dengan uap profesional.',
                'price' => 7000,
                'unit' => 'kg',
                'icon' => 't-shirt',
                'sort_order' => 3,
            ],
            [
                'name' => 'Cuci Karpet',
                'description' => 'Layanan cuci karpet khusus dengan deterjen dan peralatan ekstra untuk hasil maksimal.',
                'price' => 15000,
                'unit' => 'kg',
                'icon' => 'rug',
                'sort_order' => 4,
            ],
            [
                'name' => 'Laundry Sepatu',
                'description' => 'Cuci sepatu kesayangan dengan perawatan khusus. Kembali bersih seperti baru.',
                'price' => 25000,
                'unit' => 'pasang',
                'icon' => 'shoe',
                'sort_order' => 5,
            ],
            [
                'name' => 'Express (6 Jam)',
                'description' => 'Butuh cepat? Layanan express 6 jam selesai. Cocok untuk kebutuhan mendesak.',
                'price' => 15000,
                'unit' => 'kg',
                'icon' => 'clock',
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['name' => $service['name']], $service);
        }
    }
}
