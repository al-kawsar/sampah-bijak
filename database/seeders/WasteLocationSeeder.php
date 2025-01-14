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
                'name' => 'TPA PASIE RAJA',
                'type' => 'TPA',
                'address' => '',
                'latitude' => '',
                'longitude' => '',
                'capacity' => 1220,
                'contact_number' => '0812-9876-5432',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TPA SELAMAT INDAH',
                'type' => 'TPA',
                'address' => '',
                'latitude' => '',
                'longitude' => '',
                'capacity' => 1220,
                'contact_number' => '0812-9876-5432',
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
