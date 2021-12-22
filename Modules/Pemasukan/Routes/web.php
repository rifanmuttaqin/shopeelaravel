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

});
