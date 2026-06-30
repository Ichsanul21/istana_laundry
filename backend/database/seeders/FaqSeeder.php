<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Berapa lama waktu pengerjaan laundry?',
                'answer' => 'Layanan reguler selesai dalam 1x24 jam. Kami juga menyediakan layanan express 6 jam untuk kebutuhan mendesak.',
                'category' => 'Layanan',
                'sort_order' => 1,
            ],
            [
                'question' => 'Apakah ada layanan antar-jemput?',
                'answer' => 'Ya, kami menyediakan layanan antar-jemput gratis untuk area dalam radius jangkauan cabang kami.',
                'category' => 'Layanan',
                'sort_order' => 2,
            ],
            [
                'question' => 'Bagaimana cara mengecek jangkauan area saya?',
                'answer' => 'Gunakan fitur "Cek Jangkauan" di website kami. Masukkan alamat Anda, dan sistem akan menampilkan cabang terdekat yang melayani area Anda.',
                'category' => 'Layanan',
                'sort_order' => 3,
            ],
            [
                'question' => 'Apa yang harus dilakukan jika pakaian rusak?',
                'answer' => 'Kami bertanggung jawab penuh atas pakaian yang kami proses. Silakan hubungi CS kami untuk kompensasi yang sesuai.',
                'category' => 'Kebijakan',
                'sort_order' => 4,
            ],
            [
                'question' => 'Apakah ada minimal berat laundry?',
                'answer' => 'Minimal 2 kg untuk layanan reguler. Untuk layanan express minimal 1 kg.',
                'category' => 'Layanan',
                'sort_order' => 5,
            ],
            [
                'question' => 'Bagaimana cara pembayarannya?',
                'answer' => 'Pembayaran dapat dilakukan secara tunai saat pengantaran atau transfer bank. Kami juga menerima pembayaran via QRIS.',
                'category' => 'Pembayaran',
                'sort_order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(['question' => $faq['question']], $faq);
        }
    }
}
