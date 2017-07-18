<?php

use Illuminate\Http\Request;

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


Route::group(['prefix'=>'/v1'], function() {

    Route::post('/customer/set', 'CustomerController@setCustomerApi');

    Route::get('/ads', 'AdsController@getAdsApi');

    Route::get('/product/categories', 'ProductController@getCategoriesApi');
    Route::get('/products/{id}', 'ProductController@getProductsApi');
    Route::get('/product/detail/{id}', 'ProductController@getProductDetailApi');

    Route::get('/stores', 'StoreController@getStoresApi');

    Route::post('/order/prepare', 'OrderController@prepareOrderApi');
    Route::post('/order/make', 'OrderController@makeOrderApi');
    Route::get('/orders/groupbuy', 'OrderController@getGroupbuysApi');
    Route::get('/orders/express', 'OrderController@getExpressesApi');
    Route::get('/orders/self', 'OrderController@getSelfsApi');
    Route::get('/order/detail/{id}', 'OrderController@getOrderDetailApi');
    Route::post('/order/receive', 'OrderController@receiveProductApi');

    Route::get('/system/info', 'SystemController@getInfoApi');
});
