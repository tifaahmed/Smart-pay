<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder {

    public function run( ) {

        try {
            Role::all()->delete();
        } catch (\Exception $e) {
            Role::query()->forceDelete();
        }


        app( )[ PermissionRegistrar::class ] -> forgetCachedPermissions( );


        Role::create( [ 'id' => '1','name' => 'admin'       ,'guard_name' => 'web' ] )  ;
        Role::create( [ 'id' => '2','name' => 'customer'      ,'guard_name' => 'web' ] )  ;
        Role::create( [ 'id' => '3','name' => 'store'      ,'guard_name' => 'web' ] )  ;
        
    }

}
