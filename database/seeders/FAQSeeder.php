<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FAQSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'question' => 'Apa itu aplikasi "Sampah Bijak"?',
                'answer' => 'Sampah Bijak adalah aplikasi yang bertujuan mendigitalisasi proses pengelolaan sampah dari hulu ke hilir untuk mendukung keberlanjutan lingkungan.',
                'order_number' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Bagaimana cara mendaftar ke aplikasi Sampah Bijak?',
                'answer' => 'Anda dapat mendaftar dengan membuat akun menggunakan email aktif melalui halaman registrasi.',
                'order_number' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apa manfaat aplikasi Sampah Bijak?',
                'answer' => 'Aplikasi ini membantu rumah tangga, pemerintah daerah, bank sampah, dan industri daur ulang untuk mengelola sampah dengan lebih efektif.',
                'order_number' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah aplikasi ini dapat digunakan oleh komunitas atau organisasi?',
                'answer' => 'Ya, komunitas dan organisasi dapat menggunakan aplikasi ini untuk mengelola program pengelolaan sampah mereka.',
                'order_number' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah aplikasi ini tersedia secara gratis?',
                'answer' => 'Aplikasi ini tersedia secara gratis dengan fitur dasar. Fitur tambahan dapat diakses melalui paket berlangganan.',
                'order_number' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Bagaimana cara menghubungi layanan pelanggan?',
                'answer' => 'Anda dapat menghubungi layanan pelanggan melalui email support@sampahbijak.id atau melalui fitur live chat di aplikasi.',
                'order_number' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('f_a_q_s')->insert($faqs);
    }
}
