<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserProfile::factory()->count(10)->create();

        $profiles = UserProfile::factory()->count(10)->create();

        foreach ($profiles as $profile) {
            Log::info('User  Profile Created: ', ['user_id' => $profile->user_id]);
        }
    }
}
