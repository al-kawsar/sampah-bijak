<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Region;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = Region::all();
        $roles = Role::all();



        foreach ($regions as $region) {
            User::create([
                'id' => str()->uuid(),
                'username' => 'Pemerintah ' . ucfirst($region->region_name),
                'email' => 'pemerintah_' . strtolower($region->region_name) . '_' . str()->random(5) . '@sampahbijak.id',
                'password' => bcrypt('password'),
                'region_id' => $region->id,
                'role_id' => $roles->where('name', 'pemerintah')->first()->id,
            ]);

            // Membuat user petugas
            User::create([
                'id' => str()->uuid(),
                'username' => 'Petugas ' . ucfirst($region->region_name),
                'email' => 'petugas_' . strtolower($region->region_name) . '_' . str()->random(5) . '@sampahbijak.id',
                'password' => bcrypt('password'),
                'region_id' => $region->id,
                'role_id' => $roles->where('name', 'petugas')->first()->id,
            ]);

            // Membuat user warga
            User::create([
                'id' => str()->uuid(),
                'username' => 'Warga ' . ucfirst($region->region_name),
                'email' => 'warga_' . strtolower($region->region_name) . '_' . str()->random(5) . '@sampahbijak.id',
                'password' => bcrypt('password'),
                'region_id' => $region->id,
                'role_id' => $roles->where('name', 'warga')->first()->id,
            ]);

            // Membuat user admin
            User::create([
                'id' => str()->uuid(),
                'username' => 'admin_' . ucfirst($region->region_name),
                'email' => 'admin_' . strtolower($region->region_name) . '_' . str()->random(5) . '@sampahbijak.id',
                'password' => bcrypt('password'),
                'region_id' => $region->id,
                'role_id' => $roles->where('name', 'admin')->first()->id,
            ]);
        }
    }
}
