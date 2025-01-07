<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LearningModuleSeeder extends Seeder
{
    public function run()
    {
        $learningModules = [
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'Pengelolaan Sampah Rumah Tangga',
                'description' => 'Panduan praktis untuk mengelola sampah rumah tangga dengan bijak.',
                'content' => '
                    <h2>Pengenalan</h2>
                    <p>Sampah rumah tangga adalah salah satu penyumbang utama limbah. Dengan pengelolaan yang baik, kita bisa mengurangi dampak negatifnya terhadap lingkungan.</p>
                    <h3>Langkah-Langkah Pengelolaan Sampah</h3>
                    <ol>
                        <li><b>Pilah Sampah:</b> Pisahkan sampah organik, anorganik, dan B3 (Bahan Berbahaya dan Beracun).</li>
                        <li><b>Gunakan Bank Sampah:</b> Kirim sampah yang bisa didaur ulang ke bank sampah terdekat.</li>
                        <li><b>Kompos:</b> Ubah sampah organik menjadi pupuk kompos.</li>
                        <li><b>Kurangi Sampah Plastik:</b> Gunakan tas belanja kain atau produk ramah lingkungan lainnya.</li>
                    </ol>
                    <p>Dengan langkah-langkah ini, Anda dapat membantu menjaga kebersihan lingkungan.</p>
                ',
                'thumbnail' => 'https://waste4change.com/blog/wp-content/uploads/9D13FE3C-FBBC-4FD9-B5F2-CA92F569673B-1-350x233.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'Daur Ulang Sampah Plastik',
                'description' => 'Pelajari cara mendaur ulang sampah plastik untuk membantu keberlanjutan lingkungan.',
                'content' => '
                    <h2>Mengapa Daur Ulang Plastik Penting?</h2>
                    <p>Plastik membutuhkan ratusan tahun untuk terurai. Dengan mendaur ulang, kita bisa mengurangi sampah yang menumpuk di TPA.</p>
                    <h3>Cara Mendaur Ulang Sampah Plastik</h3>
                    <ul>
                        <li>Cuci bersih botol plastik sebelum mendaur ulang.</li>
                        <li>Pisahkan berdasarkan jenis plastik (PET, HDPE, dll).</li>
                        <li>Kirim plastik ke tempat daur ulang atau bank sampah.</li>
                    </ul>
                    <p>Daur ulang plastik tidak hanya mengurangi limbah, tetapi juga mendukung ekonomi sirkular.</p>
                ',
                'thumbnail' => 'https://waste4change.com/blog/wp-content/uploads/9D13FE3C-FBBC-4FD9-B5F2-CA92F569673B-1-350x233.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'Komunitas Peduli Sampah',
                'description' => 'Cara membangun komunitas yang peduli terhadap pengelolaan sampah.',
                'content' => '
                    <h2>Membangun Komunitas</h2>
                    <p>Komunitas dapat menjadi agen perubahan dalam pengelolaan sampah. Berikut langkah-langkah untuk memulai:</p>
                    <ol>
                        <li><b>Identifikasi Masalah:</b> Tentukan isu sampah utama di lingkungan Anda.</li>
                        <li><b>Ajukan Solusi:</b> Edukasi masyarakat tentang pentingnya pengelolaan sampah.</li>
                        <li><b>Adakan Kegiatan:</b> Buat program seperti gotong-royong atau pelatihan daur ulang.</li>
                    </ol>
                    <p>Bersama-sama, kita bisa menciptakan lingkungan yang lebih bersih dan sehat.</p>
                ',
                'thumbnail' => 'https://waste4change.com/blog/wp-content/uploads/9D13FE3C-FBBC-4FD9-B5F2-CA92F569673B-1-350x233.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('learning_modules')->insert($learningModules);
    }
}
