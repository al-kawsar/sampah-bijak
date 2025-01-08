<?php

namespace Database\Seeders;

use App\Models\PickupSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PickupScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PickupSchedule::factory()->create(['pickup_date' => '2023-10-01', 'pickup_time' => '10:00:00', 'notes' => 'Please pick up from the front door.', 'status' => 'pending']);
        PickupSchedule::factory()->create(['pickup_date' => '2023-10-02', 'pickup_time' => '11:00:00', 'notes' => 'Pickup from the backyard.', 'status' => 'confirmed']);
    }
}
