<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::firstOrCreate([
            'name' => 'super-admin' ,
            'email' => 'super@gmail.com' ,
            'phone' => '09666688546'
        ],[
            'password' => '123456789' ,
//            'password' => Hash::make('123456789'),
            'status' => StatusEnum::ACTIVE
        ]);


        $admin = Admin::where('email','super@gmail.com')->first();
        $admin->assignRole(RoleEnum::SUPER_ADMIN);


//        $admin = Admin::where('email','admin@gmail.com')->first();
//        $admin->assignRole(RoleEnum::ADMIN);

        $admin->givePermissionTo(PermissionEnum::VIEW_ADMINS);
    }
}
