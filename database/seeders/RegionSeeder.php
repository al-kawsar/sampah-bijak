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
        Region::create(['region_name' => 'Jakarta']);
        Region::create(['region_name' => 'Bandung']);
        Region::create(['region_name' => 'Surabaya']);
        Region::create(['region_name' => 'Medan']);
        Region::create(['region_name' => 'Bali']);
    }
}
