<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
        ]);

        // These seeders are generated with [orangehill/iseed]
        $this->call(
            NovaSettingsTableSeeder::class,
        );
    }
}
