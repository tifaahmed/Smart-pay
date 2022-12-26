<?php

use Illuminate\Support\Facades\Route;


Route::get('storage_link', function (){
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});


// Route::get( '/dashboard/{any}' , fn( ) => view( 'admin-panel' ) )-> where( 'any' , '.*' )   -> name( 'admin' ) ;
// Route::get( '/dashboard' , fn( ) => view( 'admin-panel' ) ) ;

 
Route::get('/dashboard/{any}','HomeController@admin_panel')-> where( 'any' , '.*' )-> name( 'admin' ) ;



Route::get( '/dashboard', function ($token) {
    return  view( 'admin-panel' );
}) ;



Route::get( '/reset-password/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// Route::post( '/update-password' ,  'Auth\NewPasswordController@store' )->name('password.update');

Route::get('/clear-cache', function () {
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    return 'done';
});
