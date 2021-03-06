<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/logout', 'Auth\LoginController@logout');

    Route::get('/user', 'UserController@getUserList');
    Route::get('/user/add', 'UserController@showAdd');
    Route::post('/user/save', 'UserController@saveUser');
    Route::get('/user/detail/{id}', 'UserController@showDetail');
    Route::get('/user/remove/{id}', 'UserController@deleteUser');

    Route::get('/category', 'ProductController@showCategory');
    Route::get('/category_add', 'ProductController@category_add');
    Route::post('/category', 'ProductController@saveCategory');
    Route::post('/category/updateOrder', 'ProductController@updateCategoryOrder');
    Route::delete('/category', 'ProductController@deleteCategory');


    Route::get('/products', 'ProductController@showProductList');
    Route::get('/product/new', 'ProductController@showProduct');
    Route::get('/product/{id}/edit', 'ProductController@showProduct');
    Route::post('/product', 'ProductController@saveProduct');
    Route::post('/product/uploadImage', 'ProductController@uploadImage');
    Route::post('/product/mount', 'ProductController@mountProduct');
    Route::delete('/product', 'ProductController@deleteProduct');

    // 规格
    Route::post('/rule', 'ProductController@addRule');
    Route::delete('/rule', 'ProductController@deleteRule');


	// 订单管理
    Route::get('/', 'OrderController@getOrderList');
    Route::get('/order/detail/{id}', 'OrderController@showOrder');
    Route::post('/order/{id}', 'OrderController@updateOrder');
    Route::post('/order/refund/{id}', 'OrderController@refundOrder');

    // 宣传管理
    Route::get('/ads', 'AdsController@showAds');
    Route::get('/ads/add', 'AdsController@showAdd');
    Route::get('/ads/detail/{id}', 'AdsController@showDetail');
    Route::post('/ad', 'AdsController@saveAd');
    Route::delete('/ad', 'AdsController@deleteAd');

    // 门店管理
    Route::get('/store', 'StoreController@showStores');
    Route::get('/store/add', 'StoreController@showAdd');
    Route::post('/store', 'StoreController@saveStore');
    Route::get('/store/detail/{id}', 'StoreController@showDetail');
    Route::delete('/store', 'StoreController@deleteStore');

    // 统计
    Route::get('/stat', 'StatController@index');

    // 系统设置
    Route::get('/setting', 'SystemController@index');
    Route::post('/setting', 'SystemController@saveSetting');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
