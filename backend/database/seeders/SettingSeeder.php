<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'wa_center', 'value' => '08115599199'],
            ['key' => 'wa_gatot_subroto', 'value' => '082393008888'],
            ['key' => 'company_name', 'value' => 'Istana Laundry'],
            ['key' => 'company_tagline', 'value' => 'Solusi Laundry Praktis, Bersih, & Wangi'],
            ['key' => 'company_address', 'value' => 'Jl. Wijaya Kusuma V-C, Gg. Rina, Air Hitam, Samarinda Ulu'],
            ['key' => 'company_phone', 'value' => '0811-5599-199'],
            ['key' => 'company_email', 'value' => 'istanalaundry.smd@gmail.com'],
            ['key' => 'default_meta_title', 'value' => 'Istana Laundry Samarinda — Laundry Terpercaya dengan 6 Cabang'],
            ['key' => 'default_meta_description', 'value' => 'Istana Laundry Samarinda, solusi laundry praktis bersih dan wangi. 6 cabang siap melayani cuci kering, setrika, express, dan antar-jemput gratis.'],
        ];

        foreach ($settings as $s) {
            Setting::firstOrCreate(['key' => $s['key']], $s);
        }
    }
}
