<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => str()->uuid(),
            'username' => "alkawsar",
            'email' => "raihanalkawsar92@gmail.com",
            'password' => "despasit0",
            'role_id' => 3,
            'region_id' => \App\Models\Region::inRandomOrder()->first()->id,
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
