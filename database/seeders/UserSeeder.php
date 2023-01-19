<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            User::where('email','admin@admin.com')->delete();
            User::where('email','admin@admin.com')->forceDelete();
        } catch (\Exception $e) {
            User::query()->forceDelete();
        }

        $admin= User::create( [
            'first_name' => 'super admin',
            'email' => 'admin@admin.com',
            'phone' => '01000011000',
            'password' => Hash::make('123456'),
            'token' => Hash::make('123456'),
            'email_verified_at' => '2022-02-14 15:30:36',
            // 'city_id' =>  City::first() ? City::first()->id : null,
        ]);
        $all_roles = Role::all()->pluck('name')->toArray();
        $admin->assignRole($all_roles);

        
    }
}
