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

use Illuminate\Support\Facades\Route;

Route::prefix('pemasukan')->group(function() {

    // -------- PRODUK -----------------------------------------------------------
    Route::get('/produk', ['as'=>'produk','uses' => 'ProdukController@index']);
    Route::get('/produk-create', ['as'=>'produk-create','uses' => 'ProdukController@create']);
    Route::get('/produk-show/{id}', ['as'=>'produk-show','uses' => 'ProdukController@show']);
    Route::get('/produk-edit/{id}', ['as'=>'produk-edit','uses' => 'ProdukController@edit']);
    Route::get('/produk-delete/{id}', ['as'=>'produk-delete','uses' => 'ProdukController@delete']);
    Route::post('/produk-store', ['as'=>'produk-store','uses' => 'ProdukController@store']);
    Route::post('/produk-update', ['as'=>'produk-update','uses' => 'ProdukController@update']);
    Route::post('/produk-destroy', ['as'=>'produk-destroy','uses' => 'ProdukController@destroy']);
    Route::post('/produk-list', ['as'=>'produk-list','uses' => 'ProdukController@list']); 

    // -------- CUSTOMER -----------------------------------------------------------
    Route::get('/customer', ['as'=>'customer-offline','uses' => 'CustomerOfflineController@index']);
    Route::get('/customer-create', ['as'=>'customer-offline-create','uses' => 'CustomerOfflineController@create']);
    Route::get('/customer-show/{id}', ['as'=>'customer-offline-show','uses' => 'CustomerOfflineController@show']);
    Route::get('/customer-edit/{id}', ['as'=>'customer-offline-edit','uses' => 'CustomerOfflineController@edit']);
    Route::get('/customer-delete/{id}', ['as'=>'customer-offline-delete','uses' => 'CustomerOfflineController@delete']);
    Route::post('/customer-store', ['as'=>'customer-offline-store','uses' => 'CustomerOfflineController@store']);
    Route::post('/customer-update', ['as'=>'customer-offline-update','uses' => 'CustomerOfflineController@update']);
    Route::post('/customer-destroy', ['as'=>'customer-offline-destroy','uses' => 'CustomerOfflineController@destroy']);
    Route::post('/customer-list', ['as'=>'customer-offline-list','uses' => 'CustomerOfflineController@list']);

});
