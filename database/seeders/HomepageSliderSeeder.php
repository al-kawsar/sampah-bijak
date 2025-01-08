<?php

namespace Database\Seeders;

use App\Models\HomepageSlider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomepageSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('homepage_sliders')->insert([
            [
                'title' => 'Slider 1',
                'description' => 'Deskripsi untuk slider 1',
                'image' => 'https://plus.unsplash.com/premium_photo-1683133531613-6a7db8847c72?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'order_number' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Slider 2',
                'description' => 'Deskripsi untuk slider 2',
                'image' => 'https://media.istockphoto.com/id/1482768515/id/foto/tangan-manusia-memegang-bola-bumi-hijau-dengan-latar-belakang-alam-kabur-konsep-selamatkan.jpg?s=612x612&w=0&k=20&c=_exK0BM60Qq933KqEhSDw7ThSN2dARxohR47Mb7LuZw=',
                'order_number' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Slider 3',
                'description' => 'Deskripsi untuk slider 3',
                'image' => 'https://plus.unsplash.com/premium_photo-1681488096924-6d4f5427c1c8?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'order_number' => 3,
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        // HomepageSlider::factory()->create(['title' => 'Welcome to Waste Management', 'description' => 'Join us in making a cleaner environment.', 'image' => 'slider1.jpg', 'link' => 'https://example.com']);
        // HomepageSlider::factory()->create(['title' => 'Get Involved', 'description' => 'Learn how you can help.', 'image' => 'slider2.jpg', 'link' => 'https://example.com']);
    }
}
