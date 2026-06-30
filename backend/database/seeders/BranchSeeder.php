<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Workshop Utama',
                'type' => 'workshop',
                'address' => 'Jl. Wijaya Kusuma V-C, Gg. Rina, Air Hitam, Samarinda Ulu',
                'lat' => -0.4869703,
                'lng' => 117.1292781,
                'radius_km' => 3,
                'phone' => '0811-5599-199',
                'open_hours' => '08:00 - 20:00',
                'sort_order' => 1,
            ],
            [
                'name' => 'Cab. Dr. Sutomo',
                'type' => 'cabang',
                'address' => 'Jl. Dr. Sutomo No.25, Sidodadi, Samarinda Ulu (samping Era Mart)',
                'lat' => -0.4798972,
                'lng' => 117.1468532,
                'radius_km' => 3,
                'phone' => null,
                'open_hours' => '08:00 - 20:00',
                'sort_order' => 2,
            ],
            [
                'name' => 'Cab. Hidayatullah',
                'type' => 'cabang',
                'address' => 'Jl. Pangeran Hidayatullah, Karang Mumus, Samarinda Kota (simpang 3 SCP)',
                'lat' => -0.5023381,
                'lng' => 117.155827,
                'radius_km' => 3,
                'phone' => null,
                'open_hours' => '08:00 - 20:00',
                'sort_order' => 3,
            ],
            [
                'name' => 'Cab. Gatot Subroto',
                'type' => 'cabang',
                'address' => 'Jl. Gatot Subroto II, depan Futsal Orion',
                'lat' => -0.4895,
                'lng' => 117.1535,
                'radius_km' => 3,
                'phone' => '0823-9300-8888',
                'open_hours' => '08:00 - 20:00',
                'sort_order' => 4,
            ],
            [
                'name' => 'Cab. Ade Irma Suryani',
                'type' => 'cabang',
                'address' => 'Jl. Ade Irma Suryani, Sungai Pinang Dalam',
                'lat' => -0.483,
                'lng' => 117.162417,
                'radius_km' => 3,
                'phone' => null,
                'open_hours' => '08:00 - 20:00',
                'sort_order' => 5,
            ],
            [
                'name' => 'Cab. Kauman',
                'type' => 'cabang',
                'address' => 'Jl. Kauman, Grand, Samarinda',
                'lat' => -0.492,
                'lng' => 117.148,
                'radius_km' => 3,
                'phone' => null,
                'open_hours' => '08:00 - 20:00',
                'sort_order' => 6,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::firstOrCreate(['name' => $branch['name']], $branch);
        }
    }
}
