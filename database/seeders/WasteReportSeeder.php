<?php

namespace Database\Seeders;

use App\Models\WasteReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WasteReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WasteReport::factory()->count(10)->create();
    }
}
