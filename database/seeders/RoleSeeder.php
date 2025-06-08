<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = RoleEnum::cases();
        foreach ($roles as $role){
            $isExists = Role::where('name' ,$role->value)->exists();
            if(!$isExists)
                Role::create(['name'=> $role->value , 'guard_name' => $role->guard()]);
        }

       $permissions = Permission::get();
       $superAdminRole = Role::where('name', RoleEnum::SUPER_ADMIN->value)->first();

       foreach ($permissions as $permission)
           $superAdminRole?->givePermissionTo($permission);
    }
}
