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

      // -------- SUPPLIER -----------------------------------------------------------
      Route::get('/supplier', ['as'=>'supplier','uses' => 'SupplierController@index']);
      Route::get('/supplier-create', ['as'=>'supplier-create','uses' => 'SupplierController@create']);
      Route::get('/supplier-show/{id}', ['as'=>'supplier-show','uses' => 'SupplierController@show']);
      Route::get('/supplier-edit/{id}', ['as'=>'supplier-edit','uses' => 'SupplierController@edit']);
      Route::get('/supplier-delete/{id}', ['as'=>'supplier-delete','uses' => 'SupplierController@delete']);
      Route::post('/supplier-store', ['as'=>'supplier-store','uses' => 'SupplierController@store']);
      Route::post('/supplier-update', ['as'=>'supplier-update','uses' => 'SupplierController@update']);
      Route::post('/supplier-destroy', ['as'=>'supplier-destroy','uses' => 'SupplierController@destroy']);
      Route::post('/supplier-list', ['as'=>'supplier-list','uses' => 'SupplierController@list']);

      // -------- Transaksi -----------------------------------------------------------
      Route::get('/transaksi-po', ['as'=>'transaksi-po','uses' => 'TransaksiPoController@index']);
      Route::get('/transaksi-po-list', ['as'=>'transaksi-po-list','uses' => 'TransaksiPoController@listTransaksi']);
      Route::post('/transaksi-po-addchart', ['as'=>'transaksi-po-addchart','uses' => 'TransaksiPoController@addchart']);
      Route::post('/transaksi-po-store', ['as'=>'transaksi-po-store','uses' => 'TransaksiPoController@store']);
      Route::get('/transaksi-po-detail/{id}', ['as'=>'transaksi-po-detail','uses' => 'TransaksiPoController@detail']);     
      Route::get('/transaksi-po-search', ['as'=>'transaksi-po-search','uses' => 'TransaksiPoController@search']);     
      Route::post('/transaksi-po-preview', ['as'=>'transaksi-po-preview','uses' => 'TransaksiPoController@preview']);
      Route::get('/transaksi-po-delete/{id}', ['as'=>'transaksi-po-delete','uses' => 'TransaksiPoController@delete']);  
      Route::post('/transaksi-po-destroy', ['as'=>'transaksi-po-destroy','uses' => 'TransaksiPoController@destroy']);

});
