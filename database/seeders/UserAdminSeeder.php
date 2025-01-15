<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::create([
            'id' => str()->uuid(),
            'username' => "ADMIN SAMPAH BIJAK",
            'email' => "admin@gmail.com",
            'password' => "despasit0",
            'role_id' => 1,
            'region_id' => \App\Models\Region::inRandomOrder()->first()->id,
        ]);

        \App\Models\UserProfile::create([
            'user_id' => $user->id,
            'full_name' => ucfirst($user->username),
            'phone_number' => '08123456789',
            'address' => 'Alamat di ' . $user->region->region_name,
            'profile_picture' => 'https://thumbs.dreamstime.com/b/vector-illustration-avatar-dummy-logo-collection-image-icon-stock-isolated-object-set-symbol-web-137160339.jpg',
        ]);
    }
}
