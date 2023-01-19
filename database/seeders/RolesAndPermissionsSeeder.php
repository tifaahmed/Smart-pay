<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder {

    public function run( ) {



        // app( )[ PermissionRegistrar::class ] -> forgetCachedPermissions( );


        Role::updateOrCreate( [ 'id' => 1 , 'name' => 'admin' ,'guard_name' => 'sanctum',] )  ;
        Role::updateOrCreate( [ 'id' => 2 , 'name' => 'customer' , 'guard_name' => 'sanctum',] )  ;
        Role::updateOrCreate( [ 'id' => 3 , 'name' => 'store' , 'guard_name' => 'sanctum',] )  ;
        Role::updateOrCreate( [ 'id' => 4 , 'name' => 'super admin' , 'guard_name' => 'sanctum',] )  ;

    }

}
