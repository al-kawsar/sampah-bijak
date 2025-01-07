<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(attributes: [
            'name' => 'admin',
            'description' => '-'
        ]);
        Role::create(attributes: [
            'name' => 'pemerintah',
            'description' => '-'
        ]);

        Role::create(attributes: [
            'name' => 'warga',
            'description' => '-'
        ]);

        Role::create(attributes: [
            'name' => 'petugas',
            'description' => '-'
        ]);

    }
}
