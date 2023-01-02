<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder {

    public function run( ) {



        // app( )[ PermissionRegistrar::class ] -> forgetCachedPermissions( );


        Role::updateOrCreate( [ 'name' => 'admin' ] )  ;
        Role::updateOrCreate( [ 'name' => 'customer'] )  ;
        Role::updateOrCreate( [ 'name' => 'store'] )  ;
        Role::updateOrCreate( [ 'name' => 'super admin'] )  ;

    }

}
