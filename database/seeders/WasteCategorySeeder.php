<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WasteCategorySeeder extends Seeder
{
    public function run()
    {
        $wasteCategories = [
            [
                'name' => 'Organik',
                'description' => 'Sampah yang berasal dari bahan alami dan dapat terurai, seperti sisa makanan, daun, dan limbah kebun.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Anorganik',
                'description' => 'Sampah yang tidak mudah terurai secara alami, seperti plastik, kaca, dan logam.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'B3 (Bahan Berbahaya dan Beracun)',
                'description' => 'Sampah yang mengandung bahan berbahaya seperti limbah elektronik, baterai, dan bahan kimia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kertas',
                'description' => 'Sampah berbahan dasar kertas seperti kardus, koran, dan majalah bekas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Logam',
                'description' => 'Sampah dari material logam seperti kaleng minuman, paku, dan barang elektronik bekas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kaca',
                'description' => 'Sampah berbahan kaca seperti botol minuman, cermin, dan kaca jendela.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tekstil',
                'description' => 'Sampah berbahan kain seperti pakaian bekas, karpet, dan limbah tekstil lainnya.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Limbah Medis',
                'description' => 'Sampah dari fasilitas kesehatan seperti masker, sarung tangan medis, dan jarum suntik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('waste_categories')->insert($wasteCategories);
    }
}
