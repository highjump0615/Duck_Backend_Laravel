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
    Route::get('/', 'OrderController@getOrderList');
    Route::get('/logout', 'Auth\LoginController@logout');
    Route::get('/user', 'UserController@getUserList');
    Route::get('/user/add', 'UserController@showAdd');
    Route::post('/user/save', 'UserController@saveUser');
    Route::get('/user/detail/{id}', 'UserController@showDetail');
    Route::get('/user/remove/{id}', 'UserController@deleteUser');

    Route::get('/category', 'ProductController@showCategory');
    Route::get('/category_add', 'ProductController@category_add');
    Route::post('/category', 'ProductController@saveCategory');

    Route::get('/products', 'ProductController@showProductList');
    Route::get('/product/new', 'ProductController@showProduct');
    Route::get('/product/{id}/edit', 'ProductController@showProduct');
    Route::post('/product', 'ProductController@saveProduct');
    Route::delete('/product', 'ProductController@deleteProduct');

    Route::post('/rule', 'ProductController@addRule');
    
});
