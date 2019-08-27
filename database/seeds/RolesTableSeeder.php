<?php

use Illuminate\Database\Seeder;
use Modules\User\Entities\Permission;
use Modules\User\Entities\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();
        $roles = config('role');
        foreach ($roles as $role) {
            $role = Role::create($role);
            foreach ($permissions as $permission) {
                $role->perms()->attach($permission);
            }
        }
    }
}
