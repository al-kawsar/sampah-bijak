<?php

namespace Database\Seeders;

use App\Models\WasteReminder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WasteReminderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WasteReminder::factory()->create(['title' => 'Weekly Waste Pickup', 'description' => 'Reminder for weekly waste pickup.', 'reminder_time' => '08:00:00', 'frequency' => 'weekly', 'is_active' => true]);
        WasteReminder::factory()->create(['title' => 'Monthly Recycling Reminder', 'description' => 'Reminder for monthly recycling.', 'reminder_time' => '09:00:00', 'frequency' => 'monthly', 'is_active' => true]);
    }
}
