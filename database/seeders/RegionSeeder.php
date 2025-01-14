<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            // Aceh
            'Banda Aceh',
            'Langsa',
            'Lhokseumawe',
            'Meulaboh',
            'Sabang',
            'Subulussalam',
            // Sumatera Utara
            'Medan',
            'Binjai',
            'Tebing Tinggi',
            'Pematangsiantar',
            'Sibolga',
            'Gunungsitoli',
            // Sumatera Barat
            'Padang',
            'Bukittinggi',
            'Solok',
            'Payakumbuh',
            'Pariaman',
            'Sawahlunto',
            // Riau
            'Pekanbaru',
            'Dumai',
            // Kepulauan Riau
            'Tanjungpinang',
            'Batam',
            // Jambi
            'Jambi',
            'Sungai Penuh',
            // Sumatera Selatan
            'Palembang',
            'Prabumulih',
            'Lubuklinggau',
            'Pagar Alam',
            // Bangka Belitung
            'Pangkalpinang',
            // Bengkulu
            'Bengkulu',
            // Lampung
            'Bandar Lampung',
            'Metro',
            // DKI Jakarta
            'Jakarta Pusat',
            'Jakarta Utara',
            'Jakarta Barat',
            'Jakarta Selatan',
            'Jakarta Timur',
            // Banten
            'Serang',
            'Tangerang',
            'Cilegon',
            'Tangerang Selatan',
            // Jawa Barat
            'Bandung',
            'Bekasi',
            'Bogor',
            'Cimahi',
            'Cirebon',
            'Depok',
            'Sukabumi',
            'Tasikmalaya',
            'Banjar',
            // Jawa Tengah
            'Semarang',
            'Magelang',
            'Surakarta (Solo)',
            'Salatiga',
            'Tegal',
            'Pekalongan',
            // DI Yogyakarta
            'Yogyakarta',
            // Jawa Timur
            'Surabaya',
            'Malang',
            'Kediri',
            'Blitar',
            'Madiun',
            'Mojokerto',
            'Pasuruan',
            'Probolinggo',
            'Batu',
            // Bali
            'Denpasar',
            // Nusa Tenggara Barat
            'Mataram',
            'Bima',
            // Nusa Tenggara Timur
            'Kupang',
            // Kalimantan Barat
            'Pontianak',
            'Singkawang',
            // Kalimantan Tengah
            'Palangka Raya',
            // Kalimantan Selatan
            'Banjarmasin',
            'Banjarbaru',
            // Kalimantan Timur
            'Samarinda',
            'Balikpapan',
            'Bontang',
            // Kalimantan Utara
            'Tarakan',
            // Sulawesi Utara
            'Manado',
            'Bitung',
            'Tomohon',
            'Kotamobagu',
            // Gorontalo
            'Gorontalo',
            // Sulawesi Tengah
            'Palu',
            // Sulawesi Selatan
            'Makassar',
            'Parepare',
            'Palopo',
            // Sulawesi Tenggara
            'Kendari',
            'Baubau',
            // Sulawesi Barat
            'Mamuju',
            // Maluku
            'Ambon',
            'Tual',
            // Maluku Utara
            'Ternate',
            'Tidore Kepulauan',
            // Papua Barat
            'Manokwari',
            'Sorong',
            // Papua
            'Jayapura',
            'Merauke',
            'Timika',
            // Papua Selatan
            'Merauke',
            // Papua Tengah
            'Nabire',
            // Papua Pegunungan
            'Wamena',
            // Papua Barat Daya
            'Sorong Selatan',
        ];


        $regions = [
            // Aceh
            'Banda Aceh',
            'Langsa',
            'Lhokseumawe'
        ];

        foreach ($regions as $region) {
            Region::create(['region_name' => $region]);
        }
    }
}
