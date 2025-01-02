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
            'name' => "Andi Muh. Raihan Alkawsar",
            'email' => "raihanalkawsar92@gmail.com",
            'password' => "despasit0",
        ]);
    }
}
