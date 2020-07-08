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
        $mikel->name = 'Mikel';
        $mikel->first_surname = 'Goig';
        $mikel->email = 'mikel@binalogue.com';
        $mikel->password = Hash::make('secret');
        $mikel->email_verified_at = now();
        $mikel->password_changed_at = now();
        $mikel->save();
        $mikel->assignRole(Role::SUPERADMIN);
    }
}
