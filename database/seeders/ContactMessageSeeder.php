<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ContactMessage::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com', 'subject' => 'Inquiry', 'message' => 'I would like to know more about your services.', 'status' => 'unread']);
        // ContactMessage::factory()->create(['name' => ' Jane Smith', 'email' => 'jane@example.com', 'subject' => 'Feedback', 'message' => 'Great service! Keep it up.', 'status' => 'read']);
    }
}
