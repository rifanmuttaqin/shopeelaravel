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
    Route::post('/produk-store', ['as'=>'produkpo-store','uses' => 'ProdukpoController@store']);

});
