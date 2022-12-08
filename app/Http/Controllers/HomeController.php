<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{


    public function admin_panel()
    {
        return  view( 'admin-panel' );
    }
}
