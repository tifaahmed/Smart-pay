<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run( ) {
        // $this -> call ( SiteSettingSeeder::class );
        // $this -> call ( RolesAndPermissionsSeeder::class );
        $this -> call ( UserSeeder::class );

    }
}
