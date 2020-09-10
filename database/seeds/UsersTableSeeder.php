<?php

use Domain\Users\Models\Role;
use Domain\Users\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mikel = new User();
        $mikel->first_name = 'Mikel';
        $mikel->last_name = 'Goig';
        $mikel->email = 'mikel@binalogue.com';
        $mikel->password = Hash::make('secret');
        $mikel->email_verified_at = now();
        $mikel->password_changed_at = now();
        $mikel->save();
        $mikel->assignRole(Role::SUPERADMIN);

        $marcus = new User();
        $marcus->first_name = 'Marcus';
        $marcus->last_name = 'Stenbeck';
        $marcus->email = 'marcus@binalogue.com';
        $marcus->password = Hash::make('secret');
        $marcus->email_verified_at = now();
        $mikel->password_changed_at = now();
        $marcus->save();
        $marcus->assignRole(Role::SUPERADMIN);
    }
}
