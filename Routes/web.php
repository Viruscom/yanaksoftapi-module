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

Route::prefix('system/apis/yanaksoftapi')->group(function () {
    Route::get('/getToken', 'YanakSoftApiController@getToken');
    Route::get('/getAllStocks', 'YanakSoftApiController@getAllStocks');
    Route::get('/getAllCategories', 'YanakSoftApiController@getAllCategories');
    Route::get('/getAllCustomers', 'YanakSoftApiController@getAllCustomers');
});
