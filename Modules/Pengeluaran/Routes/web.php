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

      // -------- PRODUK -----------------------------------------------------------
      Route::get('/produk', ['as'=>'produkpo','uses' => 'ProdukpoController@index']);
      Route::get('/produk-create', ['as'=>'produkpo-create','uses' => 'ProdukpoController@create']);
      Route::get('/produk-show/{id}', ['as'=>'produkpo-show','uses' => 'ProdukpoController@show']);
      Route::get('/produk-edit/{id}', ['as'=>'produkpo-edit','uses' => 'ProdukpoController@edit']);
      Route::get('/produk-delete/{id}', ['as'=>'produkpo-delete','uses' => 'ProdukpoController@delete']);
      Route::post('/produk-store', ['as'=>'produkpo-store','uses' => 'ProdukpoController@store']);
      Route::post('/produk-update', ['as'=>'produkpo-update','uses' => 'ProdukpoController@update']);
      Route::post('/produk-destroy', ['as'=>'produkpo-destroy','uses' => 'ProdukpoController@destroy']); 


      // -------- SUPPLIER -----------------------------------------------------------
      Route::get('/supplier', ['as'=>'supplier','uses' => 'SupplierController@index']);
      Route::get('/supplier-create', ['as'=>'supplier-create','uses' => 'SupplierController@create']);
      Route::get('/supplier-show/{id}', ['as'=>'supplier-show','uses' => 'SupplierController@show']);
      Route::get('/supplier-edit/{id}', ['as'=>'supplier-edit','uses' => 'SupplierController@edit']);
      Route::get('/supplier-delete/{id}', ['as'=>'supplier-delete','uses' => 'SupplierController@delete']);
      Route::post('/supplier-store', ['as'=>'supplier-store','uses' => 'SupplierController@store']);
      Route::post('/supplier-update', ['as'=>'supplier-update','uses' => 'SupplierController@update']);
      Route::post('/supplier-destroy', ['as'=>'supplier-destroy','uses' => 'SupplierController@destroy']);

      
});
