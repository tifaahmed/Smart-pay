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

 

// no middleware
Route::name( 'auth.') -> prefix( 'auth' ) -> group( fn ( ) => [
    Route::post( '/login' ,   'AuthController@login'  ) -> name( 'login' ) ,
    // Route::post( '/login-social' ,   'AuthController@loginSocial'  ) -> name( 'loginSocial' ) ,
    Route::post( '/register' ,  'AuthController@register' )  -> name( 'register' ) ,    
]);
Route::name('language.')->prefix('/language')->group( fn ( ) : array => [
    Route::get('/'                          ,   'LanguageController@all'                 )->name('all'),
]);


Route::group(['middleware' => ['LocalizationMiddleware','auth:sanctum','role:admin']], fn ( ) : array => [
    // slider
    // Route::name('slider.')->prefix('/slider')->group( fn ( ) : array => [
    //     Route::get('/'                          ,   'SliderController@all'                 )->name('all'),
    //     Route::post(''                          ,   'SliderController@store'               )->name('store'),
    //     Route::get('/{id}/show'                 ,   'SliderController@show'                )->name('show'),
    //     Route::get('/collection'                ,   'SliderController@collection'          )->name('collection'),
    //     Route::DELETE('/{id}'                   ,   'SliderController@destroy'             )->name('destroy'),
    //     Route::post('/{id}/update'              ,   'SliderController@update'              )->name('update')
    // ]),
    // coupon
    Route::name('coupon.')->prefix('/coupon')->group( fn ( ) : array => [
        Route::get('/'                          ,   'CouponController@all'                 )->name('all'),
        Route::post(''                          ,   'CouponController@store'               )->name('store'),
        Route::get('/{id}/show'                 ,   'CouponController@show'                )->name('show'),
        Route::get('/collection'                ,   'CouponController@collection'          )->name('collection'),
        Route::DELETE('/{id}'                   ,   'CouponController@destroy'             )->name('destroy'),
        Route::post('/{id}/update'              ,   'CouponController@update'              )->name('update'),
    ]),

    // ExtraCategory
    Route::name('extra-category.')->prefix('/extra-category')->group( fn ( ) : array => [
        Route::get('/'                          ,   'ExtraCategoryController@all'                 )->name('all'),
        Route::post(''                          ,   'ExtraCategoryController@store'               )->name('store'),
        Route::get('/{id}/show'                 ,   'ExtraCategoryController@show'                )->name('show'),
        Route::get('/collection'                ,   'ExtraCategoryController@collection'          )->name('collection'),
        Route::DELETE('/{id}'                   ,   'ExtraCategoryController@destroy'             )->name('destroy'),
        Route::post('/{id}/update'              ,   'ExtraCategoryController@update'              )->name('update'),
    ]),
    // extra
    Route::name('extra.')->prefix('/extra')->group( fn ( ) : array => [
        Route::get('/'                          ,   'ExtraController@all'                 )->name('all'),
        Route::post(''                          ,   'ExtraController@store'               )->name('store'),
        Route::get('/{id}/show'                 ,   'ExtraController@show'                )->name('show'),
        Route::get('/collection'                ,   'ExtraController@collection'          )->name('collection'),
        Route::DELETE('/{id}'                   ,   'ExtraController@destroy'             )->name('destroy'),
        Route::post('/{id}/update'              ,   'ExtraController@update'              )->name('update'),
    ]),
    
    // country
    Route::name('country.')->prefix('/country')->group( fn ( ) : array => [
        Route::get('/'                          ,   'CountryController@all'                 )->name('all'),
        Route::post(''                          ,   'CountryController@store'               )->name('store'),
        Route::get('/{id}/show'                 ,   'CountryController@show'                )->name('show'),
        Route::get('/collection'                ,   'CountryController@collection'          )->name('collection'),
        Route::DELETE('/{id}'                   ,   'CountryController@destroy'             )->name('destroy'),
        Route::post('/{id}/update'              ,   'CountryController@update'              )->name('update'),
        
        Route::get('/{id}/restore'              ,   'CountryController@restore'             )->name('restore'),
        Route::DELETE('premanently-delete/{id}' ,   'CountryController@premanently_delete'  )->name('premanently_delete'),
        Route::get('/collection-trash'          ,   'CountryController@collection_trash'    )->name('collection_trash'),
        Route::get('/{id}/show-trash'           ,   'CountryController@show_trash'          )->name('show_trash'),
    ]),
    // government
    Route::name('government.')->prefix('/government')->group( fn ( ) : array => [
        Route::get('/'                          ,   'GovernmentController@all'                 )->name('all'),
        Route::post(''                          ,   'GovernmentController@store'               )->name('store'),
        Route::get('/{id}/show'                 ,   'GovernmentController@show'                )->name('show'),
        Route::get('/collection'                ,   'GovernmentController@collection'          )->name('collection'),
        Route::DELETE('/{id}'                   ,   'GovernmentController@destroy'             )->name('destroy'),
        Route::post('/{id}/update'              ,   'GovernmentController@update'              )->name('update'),
        
        Route::get('/{id}/restore'              ,   'GovernmentController@restore'             )->name('restore'),
        Route::DELETE('premanently-delete/{id}' ,   'GovernmentController@premanently_delete'  )->name('premanently_delete'),
        Route::get('/collection-trash'          ,   'GovernmentController@collection_trash'    )->name('collection_trash'),
        Route::get('/{id}/show-trash'           ,   'GovernmentController@show_trash'          )->name('show_trash'),
    ]),
    // government
    Route::name('city.')->prefix('/city')->group( fn ( ) : array => [
        Route::get('/'                          ,   'CityController@all'                 )->name('all'),
        Route::post(''                          ,   'CityController@store'               )->name('store'),
        Route::get('/{id}/show'                 ,   'CityController@show'                )->name('show'),
        Route::get('/collection'                ,   'CityController@collection'          )->name('collection'),
        Route::DELETE('/{id}'                   ,   'CityController@destroy'             )->name('destroy'),
        Route::post('/{id}/update'              ,   'CityController@update'              )->name('update'),
        
        Route::get('/{id}/restore'              ,   'CityController@restore'             )->name('restore'),
        Route::DELETE('premanently-delete/{id}' ,   'CityController@premanently_delete'  )->name('premanently_delete'),
        Route::get('/collection-trash'          ,   'CityController@collection_trash'    )->name('collection_trash'),
        Route::get('/{id}/show-trash'           ,   'CityController@show_trash'          )->name('show_trash'),
    ]),
    // Site-Setting
    Route::name('site-setting.')->prefix('/site-setting')->group( fn ( ) : array => [
        Route::get('/'                          ,   'SiteSettingController@all'                 )->name('all'),
        Route::get('/{id}/show'                 ,   'SiteSettingController@show'                )->name('show'),
        Route::get('/collection'                ,   'SiteSettingController@collection'          )->name('collection'),
        Route::post('/{id}/update'              ,   'SiteSettingController@update'              )->name('update'),
    ]),
    // product-category
    Route::name('product-category.')->prefix('/product-category')->group( fn ( ) : array => [
        Route::get('/'                          ,   'ProductCategoryController@all'                 )->name('all'),
        Route::post(''                          ,   'ProductCategoryController@store'               )->name('store'),
        Route::get('/{id}/show'                 ,   'ProductCategoryController@show'                )->name('show'),
        Route::get('/collection'                ,   'ProductCategoryController@collection'          )->name('collection'),
        Route::DELETE('/{id}'                   ,   'ProductCategoryController@destroy'             )->name('destroy'),
        Route::post('/{id}/update'              ,   'ProductCategoryController@update'              )->name('update'),
        
        Route::get('/{id}/restore'              ,   'ProductCategoryController@restore'             )->name('restore'),
        Route::DELETE('premanently-delete/{id}' ,   'ProductCategoryController@premanently_delete'  )->name('premanently_delete'),
        Route::get('/collection-trash'          ,   'ProductCategoryController@collection_trash'    )->name('collection_trash'),
        Route::get('/{id}/show-trash'           ,   'ProductCategoryController@show_trash'          )->name('show_trash'),
    ]),

    // product-category
    Route::name('product-item.')->prefix('/product-item')->group( fn ( ) : array => [
        Route::get('/'                          ,   'ProductItemsController@all'                 )->name('all'),
        Route::post(''                          ,   'ProductItemsController@store'               )->name('store'),
        Route::get('/{id}/show'                 ,   'ProductItemsController@show'                )->name('show'),
        Route::get('/collection'                ,   'ProductItemsController@collection'          )->name('collection'),
        Route::DELETE('/{id}'                   ,   'ProductItemsController@destroy'             )->name('destroy'),
        Route::post('/{id}/update'              ,   'ProductItemsController@update'              )->name('update'),
        
        Route::get('/{id}/restore'              ,   'ProductItemsController@restore'             )->name('restore'),
        Route::DELETE('premanently-delete/{id}' ,   'ProductItemsController@premanently_delete'  )->name('premanently_delete'),
        Route::get('/collection-trash'          ,   'ProductItemsController@collection_trash'    )->name('collection_trash'),
        Route::get('/{id}/show-trash'           ,   'ProductItemsController@show_trash'          )->name('show_trash'),
    ]),

    // product-category
    Route::name('store.')->prefix('/store')->group( fn ( ) : array => [
        Route::get('/'                          ,   'StoreController@all'                 )->name('all'),
        Route::post(''                          ,   'StoreController@store'               )->name('store'),
        Route::get('/{id}/show'                 ,   'StoreController@show'                )->name('show'),
        Route::get('/collection'                ,   'StoreController@collection'          )->name('collection'),
        Route::DELETE('/{id}'                   ,   'StoreController@destroy'             )->name('destroy'),
        Route::post('/{id}/update'              ,   'StoreController@update'              )->name('update'),
        
        Route::get('/{id}/restore'              ,   'StoreController@restore'             )->name('restore'),
        Route::DELETE('premanently-delete/{id}' ,   'StoreController@premanently_delete'  )->name('premanently_delete'),
        Route::get('/collection-trash'          ,   'StoreController@collection_trash'    )->name('collection_trash'),
        Route::get('/{id}/show-trash'           ,   'StoreController@show_trash'          )->name('show_trash'),
    ]),
    // product-category
    Route::name('user.')->prefix('/user')->group( fn ( ) : array => [
        Route::get('/'                          ,   'UserController@all'                 )->name('all'),
        Route::post(''                          ,   'UserController@store'               )->name('store'),
        Route::get('/{id}/show'                 ,   'UserController@show'                )->name('show'),
        Route::get('/collection'                ,   'UserController@collection'          )->name('collection'),
        Route::DELETE('/{id}'                   ,   'UserController@destroy'             )->name('destroy'),
        Route::post('/{id}/update'              ,   'UserController@update'              )->name('update'),
        
        Route::get('/{id}/restore'              ,   'UserController@restore'             )->name('restore'),
        Route::DELETE('premanently-delete/{id}' ,   'UserController@premanently_delete'  )->name('premanently_delete'),
        Route::get('/collection-trash'          ,   'UserController@collection_trash'    )->name('collection_trash'),
        Route::get('/{id}/show-trash'           ,   'UserController@show_trash'          )->name('show_trash'),
    ]),
    // order
    Route::name('order.')->prefix('/order')->group( fn ( ) : array => [
        Route::get('/'                          ,   'OrderController@all'                 )->name('all'),
        Route::post(''                          ,   'OrderController@store'               )->name('store'),
        Route::get('/{id}/show'                 ,   'OrderController@show'                )->name('show'),
        Route::get('/collection'                ,   'OrderController@collection'          )->name('collection'),
        Route::DELETE('/{id}'                   ,   'OrderController@destroy'             )->name('destroy'),
        Route::post('/{id}/update'              ,   'OrderController@update'              )->name('update'),
        
        Route::get('/{id}/restore'              ,   'OrderController@restore'             )->name('restore'),
        Route::DELETE('premanently-delete/{id}' ,   'OrderController@premanently_delete'  )->name('premanently_delete'),
        Route::get('/collection-trash'          ,   'OrderController@collection_trash'    )->name('collection_trash'),
        Route::get('/{id}/show-trash'           ,   'OrderController@show_trash'          )->name('show_trash'),
    ]),
    // order_item
        Route::name('order_item.')->prefix('/order_item')->group( fn ( ) : array => [
            Route::get('/'                 ,   'OrderItemController@all'                 )->name('all'),
            Route::post(''                 ,   'OrderItemController@store'               )->name('store'),
            Route::get('/{id}/show'        ,   'OrderItemController@show'                )->name('show'),
            Route::get('/collection'       ,   'OrderItemController@collection'          )->name('collection'),
            Route::DELETE('/{id}'          ,   'OrderItemController@destroy'             )->name('destroy'),
            Route::post('/{id}/update'     ,   'OrderItemController@update'              )->name('update'),
        ]),
    // order_item
        Route::name('order_item_extra.')->prefix('/order_item_extra')->group( fn ( ) : array => [
            Route::get('/'                  ,   'OrderItemExtraController@all'          )->name('all'),
            Route::post(''                  ,   'OrderItemExtraController@store'        )->name('store'),
            Route::get('/{id}/show'         ,   'OrderItemExtraController@show'         )->name('show'),
            Route::get('/collection'        ,   'OrderItemExtraController@collection'   )->name('collection'),
            Route::DELETE('/{id}'           ,   'OrderItemExtraController@destroy'      )->name('destroy'),
            Route::post('/{id}/update'      ,   'OrderItemExtraController@update'       )->name('update'),
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
    
]);
    