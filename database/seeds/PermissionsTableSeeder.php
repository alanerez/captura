<?php

use Illuminate\Database\Seeder;
use Modules\User\Entities\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('permission');
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
