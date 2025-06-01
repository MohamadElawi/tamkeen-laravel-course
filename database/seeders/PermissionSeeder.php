<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'view admins','guard_name' => 'admin']);
        Permission::create(['name' => 'create admins','guard_name' => 'admin']);
        Permission::create(['name' => 'update admins','guard_name' => 'admin']);
        Permission::create(['name' => 'delete admins','guard_name' => 'admin']);
        Permission::create(['name' => 'view users','guard_name' => 'admin']);
        Permission::create(['name' => 'create user','guard_name' => 'admin']);
        Permission::create(['name' => 'update user','guard_name' => 'admin']);
        Permission::create(['name' => 'delete user','guard_name' => 'admin']);
        Permission::create(['name' => 'view products','guard_name' => 'admin']);
        Permission::create(['name' => 'create product','guard_name' => 'admin']);
        Permission::create(['name' => 'update product','guard_name' => 'admin']);
        Permission::create(['name' => 'delete product','guard_name' => 'admin']);

    }

}
