<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Event;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    public function run()
    {
        $events = [
            [
                'id' => Str::uuid()->toString(),
                'thumbnail_url' => 'https://waste4change.com/blog/wp-content/uploads/9D13FE3C-FBBC-4FD9-B5F2-CA92F569673B-1-350x233.jpg',
                'title' => 'Lokakarya Edukasi Pengelolaan Sampah',
                'description' => 'Sesi edukasi interaktif tentang pentingnya memilah sampah dan mengelolanya dengan benar untuk mendukung keberlanjutan lingkungan.',
                'date' => now()->addDays(10),
                'location' => 'Gedung Serbaguna, Jakarta',
                'organizer_id' => User::inRandomOrder()->first()->id,
                'capacity' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'title' => 'Kampanye Aksi Bersih Pantai',
                'thumbnail_url' => 'https://waste4change.com/blog/wp-content/uploads/9D13FE3C-FBBC-4FD9-B5F2-CA92F569673B-1-350x233.jpg',
                'description' => 'Bersama-sama membersihkan pantai dari sampah plastik untuk melindungi ekosistem laut.',
                'date' => now()->addDays(20),
                'location' => 'Pantai Ancol, Jakarta',
                'organizer_id' => User::inRandomOrder()->first()->id,
                'capacity' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'title' => 'Pelatihan Pengelolaan Bank Sampah',
                'thumbnail_url' => 'https://waste4change.com/blog/wp-content/uploads/9D13FE3C-FBBC-4FD9-B5F2-CA92F569673B-1-350x233.jpg',
                'description' => 'Pelatihan intensif bagi komunitas untuk memahami dan mengelola bank sampah secara efektif.',
                'date' => now()->addDays(30),
                'location' => 'Balai Komunitas, Surabaya',
                'organizer_id' => User::inRandomOrder()->first()->id,
                'capacity' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'title' => 'Pameran Inovasi Daur Ulang',
                'thumbnail_url' => 'https://waste4change.com/blog/wp-content/uploads/9D13FE3C-FBBC-4FD9-B5F2-CA92F569673B-1-350x233.jpg',
                'description' => 'Pameran yang menampilkan berbagai produk kreatif hasil daur ulang sampah, serta diskusi bersama para inovator.',
                'date' => now()->addDays(40),
                'location' => 'Convention Center, Bandung',
                'organizer_id' => User::inRandomOrder()->first()->id,
                'capacity' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'title' => 'Kompetisi Ide Kreatif Pengelolaan Sampah',
                'thumbnail_url' => 'https://waste4change.com/blog/wp-content/uploads/9D13FE3C-FBBC-4FD9-B5F2-CA92F569673B-1-350x233.jpg',
                'description' => 'Ajang bagi para pelajar dan mahasiswa untuk mengajukan ide-ide kreatif dalam pengelolaan sampah.',
                'date' => now()->addDays(50),
                'location' => 'Universitas Indonesia, Depok',
                'organizer_id' => User::inRandomOrder()->first()->id,
                'capacity' => 80,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('events')->insert($events);
    }
}
