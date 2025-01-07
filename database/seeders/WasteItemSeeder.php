<?php

namespace Database\Seeders;

use App\Models\WasteItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WasteItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WasteItem::factory()->count(10)->create();
    }
}
