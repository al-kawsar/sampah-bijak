<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WasteLocation;

class WasteLocationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'TPS Sentral Citra Indah',
                'type' => 'TPS',
                'address' => 'Jalan Citra Indah No. 123, Jakarta',
                'latitude' => -6.212845,
                'longitude' => 106.833675,
                'capacity' => 2500,
                'contact_number' => '0812-3456-7890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TPA Mandiri Jaya',
                'type' => 'TPA',
                'address' => 'Jl. Raya Mandiri No. 456, Bogor',
                'latitude' => -6.601249,
                'longitude' => 106.812080,
                'capacity' => 5000,
                'contact_number' => '0812-9876-5432',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TPS EcoGreen',
                'type' => 'TPS',
                'address' => 'Komplek EcoGreen Blok A, Bekasi',
                'latitude' => -6.241806,
                'longitude' => 106.966957,
                'capacity' => 1200,
                'contact_number' => '0812-3456-1122',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TPA MegaRecycle',
                'type' => 'TPA',
                'address' => 'Jl. Raya Industri No. 789, Tangerang',
                'latitude' => -6.162455,
                'longitude' => 106.652978,
                'capacity' => 8000,
                'contact_number' => '0812-6789-4321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TPST Organik Hijau',
                'type' => 'TPA',
                'address' => 'Jl. Hijau Lestari No. 321, Surabaya',
                'latitude' => -7.278499,
                'longitude' => 112.794547,
                'capacity' => 1500,
                'contact_number' => '0812-3456-3344',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TPBL Limbah Berbahaya Central',
                'type' => 'TPS',
                'address' => 'Jl. Berbahaya No. 555, Bandung',
                'latitude' => -6.917464,
                'longitude' => 107.620162,
                'capacity' => 4000,
                'contact_number' => '0812-4567-8899',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($data as $item) {
            WasteLocation::create([
                'name' => $item['name'],
                'type' => $item['type'],
                'address' => $item['address'],
                'latitude' => $item['latitude'],
                'longitude' => $item['longitude'],
                'capacity' => $item['capacity'],
                'contact_number' => $item['contact_number'],
            ]);
        }
    }
}
