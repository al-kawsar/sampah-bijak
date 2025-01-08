<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alkawsar = User::create([
            'id' => str()->uuid(),
            'username' => "alkawsar",
            'email' => "raihanalkawsar92@gmail.com",
            'password' => "despasit0",
            'role_id' => 3,
            'region_id' => \App\Models\Region::inRandomOrder()->first()->id,
        ]);
        UserProfile::create([
            'user_id' => $alkawsar->id,
            'full_name' => 'Andi Muh. Raihan Alkawsar',
            'phone_number' => '085931255249',
            'address' => 'JL Ince Nurdin',
            'profile_picture' => 'https://thumbs.dreamstime.com/b/vector-illustration-avatar-dummy-logo-collection-image-icon-stock-isolated-object-set-symbol-web-137160339.jpg',
        ]);

        User::create([
            'id' => str()->uuid(),
            'username' => "ADMIN SAMPAH BIJAK",
            'email' => "admin@gmail.com",
            'password' => "despasit0",
            'role_id' => 1,
            'region_id' => \App\Models\Region::inRandomOrder()->first()->id,
        ]);


    }
}
