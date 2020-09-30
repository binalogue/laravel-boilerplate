<?php

namespace Database\Seeders;

use Domain\Users\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'superadmin'],
            ['name' => 'admin'],
            ['name' => 'editor'],
        ];

        Role::insert($roles);
    }
}
