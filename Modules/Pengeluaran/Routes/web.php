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


Route::prefix('pengeluaran')->group(function() {
    Route::get('/produk', ['as'=>'produkpo','uses' => 'ProdukpoController@index']);
    Route::get('/produk-create', ['as'=>'produkpo-create','uses' => 'ProdukpoController@create']);
    Route::get('/produk-show/{id}', ['as'=>'produkpo-show','uses' => 'ProdukpoController@show']);
    Route::get('/produk-edit/{id}', ['as'=>'produkpo-edit','uses' => 'ProdukpoController@edit']);
    Route::get('/produk-delete/{id}', ['as'=>'produkpo-delete','uses' => 'ProdukpoController@delete']);
    Route::post('/produk-store', ['as'=>'produkpo-store','uses' => 'ProdukpoController@store']);
    Route::post('/produk-update', ['as'=>'produkpo-update','uses' => 'ProdukpoController@update']);
    Route::post('/produk-destroy', ['as'=>'produkpo-destroy','uses' => 'ProdukpoController@destroy']); 
});
