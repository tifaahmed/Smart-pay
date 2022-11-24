<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' =>'mobile','middleware' => ['LocalizationMiddleware']], fn ( ) : array => [



    // auth
    Route::name( 'auth.') -> prefix( 'auth') -> group( fn ( ) => [

        Route::post( '/login' ,   'AuthController@login'  ) -> name( 'login' ) ,
        Route::post( '/login-social' ,   'AuthController@loginSocial'  ) -> name( 'loginSocial' ) ,
        Route::post( '/register' ,  'AuthController@register' )  -> name( 'register' ) ,
        Route::post( '/active-acount' ,  'AuthController@active_acount' )  -> name( 'active_acount' ) , 



        Route::post( '/reset-password' ,  'Auth\ForgetPassword\PasswordResetLinkController@reset' )->name( 'password.reset' ) ,  
        Route::post( '/check-pin-code' ,  'Auth\ForgetPassword\CheckPinCodeController@check_pin_code' )  -> name( 'check_pin_code' ) , 
        Route::post( '/new-password'    ,  'Auth\ForgetPassword\NewPasswordController@new_password' )->name( 'password.new' ) ,  

    ]),

    
    // auth:sanctum // auth:sanctum
    // auth:api // passport
    Route::group(['middleware' => ['auth:sanctum','verified']], fn ( ) : array => [
        // auth
        Route::name( 'auth.') -> prefix( 'auth') -> group( fn ( ) => [
            Route::post( 'update-password' ,  'Auth\UpdatePasswordController@update_password' )  -> name( 'password.update' ),
            Route::post( 'logout' ,  'authController@logout' )  -> name( 'logout' ) ,
        ]),

        // user
        Route::name('user.')->prefix('/user')->group( fn ( ) : array => [
            Route::get('/show'                 ,   'UserController@show'                )->name('show'),
            Route::post('/update'              ,   'UserController@update'              )->name('update'),
        ]), 
        // product-category
        Route::name('product-item.')->prefix('/product-item')->group( fn ( ) : array => [
            Route::post('/fav-toggle'         ,   'ProductItemsController@fav_toggle'  )->name('fav'),
        ]),
        // store
        Route::name('store.')->prefix('store')->group( fn ( ) : array => [
            Route::post('/fav-toggle'         ,   'StoreController@fav_toggle'  )->name('fav'),
            Route::post('/rate'               ,   'StoreController@rate'        )->name('rate'),
            Route::post(''                    ,   'StoreController@store'       )->name('store'),
        ]),
        // cart
        Route::name('cart.')->prefix('cart')->group( fn ( ) : array => [
            Route::get('/'                    ,   'CartController@all'         )->name('all'),
            Route::post(''                    ,   'CartController@store'       )->name('store'),
            Route::post('/{id}/update'        ,   'CartController@update'      )->name('update'),
            Route::DELETE('/{id}'             ,   'CartController@destroy'     )->name('destroy'),

        ]),
    ]),


    
    Route::group(['middleware' => ['auth:sanctum','verified','role:customer']], fn ( ) : array => [
        Route::name('coupon.')->prefix('/coupon')->group( fn ( ) : array => [
            Route::post('/check_coupon', 'CouponController@check_coupon')->name('check_coupon'),
        ]),
        // address
        Route::name('address.')->prefix('/address')->group( fn ( ) : array => [
            Route::get('/'                          ,   'AddressController@all'                 )->name('all'),
            Route::post(''                          ,   'AddressController@store'               )->name('store'),
            Route::get('/{id}/show'                 ,   'AddressController@show'                )->name('show'),
            Route::get('/collection'                ,   'AddressController@collection'          )->name('collection'),
            Route::DELETE('/{id}'                   ,   'AddressController@destroy'             )->name('destroy'),
            Route::post('/{id}/update'              ,   'AddressController@update'              )->name('update'),
        ]),
        // country
        Route::name('country.')->prefix('/country')->group( fn ( ) : array => [
            Route::get('/'                          ,   'CountryController@all'                 )->name('all'),
            Route::get('/{id}/show'                 ,   'CountryController@show'                )->name('show'),
            Route::get('/collection'                ,   'CountryController@collection'          )->name('collection'),
        ]),

        // product-category
        Route::name('product-category.')->prefix('/product-category')->group( fn ( ) : array => [
            Route::get('/'                          ,   'ProductCategoryController@all'                 )->name('all'),
            Route::get('/{id}/show'                 ,   'ProductCategoryController@show'                )->name('show'),
            Route::get('/collection'                ,   'ProductCategoryController@collection'          )->name('collection'),
        ]),
        // product-category
        Route::name('product-item.')->prefix('/product-item')->group( fn ( ) : array => [
            Route::get('/'                          ,   'ProductItemsController@all'         )->name('all'),
            Route::get('/{id}/show'                 ,   'ProductItemsController@show'        )->name('show'),
            Route::get('/collection'                ,   'ProductItemsController@collection'  )->name('collection'),
        ]),
        // store
        Route::name('food-section.')->prefix('food-section')->group( fn ( ) : array => [
            Route::get('/'           ,   'FoodSectionController@all'          )->name('all'),
            Route::get('/{id}/show'  ,   'FoodSectionController@show'         )->name('show'),
            Route::get('/collection' ,   'FoodSectionController@collection'   )->name('collection'),
        ]),
        // store
        Route::name('store.')->prefix('store')->group( fn ( ) : array => [
            Route::get('/'                          ,   'StoreController@all'                 )->name('all'),
            Route::get('/{id}/show'                 ,   'StoreController@show'                )->name('show'),
            Route::get('/collection'                ,   'StoreController@collection'          )->name('collection'),
        ]),
        // extra-category
        Route::name('extra-category.')->prefix('extra-category')->group( fn ( ) : array => [
            Route::get('/'                          ,   'ExtraCategoryController@all'                 )->name('all'),
            Route::get('/{id}/show'                 ,   'ExtraCategoryController@show'                )->name('show'),
            Route::get('/collection'                ,   'ExtraCategoryController@collection'          )->name('collection'),
        ]),

        // order
        Route::name('order.')->prefix('/order')->group( fn ( ) : array => [
            Route::get('/'                          ,   'OrderController@all'                 )->name('all'),
            Route::post(''                          ,   'OrderController@store'               )->name('store'),
            Route::get('/{id}/show'                 ,   'OrderController@show'                )->name('show'),
            Route::get('/collection'                ,   'OrderController@collection'          )->name('collection'),
            Route::post('/{id}/update'              ,   'OrderController@update'              )->name('update'),
        ]),
    ]),





    Route::group(['middleware' => ['auth:sanctum','role:store']], fn ( ) : array => [   
        Route::name('store.')->prefix('store')->group( fn ( ) : array => [
            Route::get('/my-store'           ,   'StoreController@my_store'        )->name('my_store'),
            Route::post('update'            ,   'StoreController@update'          )->name('update'),

        ]),
    ])




]);
