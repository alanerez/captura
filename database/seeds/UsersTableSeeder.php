<?php

use Illuminate\Database\Seeder;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $role_admin = Role::where('name', 'super_admin')->first();
        $users = config('user');
        foreach ($users as $user) {
            $user = User::create($user);
            $user->roles()->attach($role_admin);
        }
    }
}
