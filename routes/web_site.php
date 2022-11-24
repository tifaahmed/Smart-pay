<?php

use Illuminate\Support\Facades\Route;


Route::get('storage_link', function (){
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});


Route::get( '/dashboard/{any}' , fn( ) => view( 'admin-panel' ) )-> where( 'any' , '.*' )   -> name( 'admin' ) ;
Route::get( '/dashboard' , fn( ) => view( 'admin-panel' ) ) ;


Route::get( '/reset-password/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post( '/update-password' ,  'Auth\NewPasswordController@store' )->name('password.update');

