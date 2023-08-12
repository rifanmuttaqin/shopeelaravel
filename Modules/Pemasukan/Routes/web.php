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
    Route::post('/customer-default', ['as'=>'customer-default','uses' => 'CustomerOfflineController@defaultCustomer']);


    // -------- Transaksi -----------------------------------------------------------
    Route::get('/transaksi-offline', ['as'=>'transaksi-offline','uses' => 'TransaksiOfflineController@index']);
    Route::get('/transaksi-offline-list', ['as'=>'transaksi-offline-list','uses' => 'TransaksiOfflineController@listTransaksi']);
    Route::post('/transaksi-offline-addchart', ['as'=>'transaksi-offline-addchart','uses' => 'TransaksiOfflineController@addchart']);
    Route::post('/transaksi-offline-store', ['as'=>'transaksi-offline-store','uses' => 'TransaksiOfflineController@store']);
    Route::get('/transaksi-offline-detail/{id}', ['as'=>'transaksi-offline-detail','uses' => 'TransaksiOfflineController@detail']); 
    Route::get('/transaksi-offline-print/{id}', ['as'=>'transaksi-offline-print','uses' => 'TransaksiOfflineController@printFaktur']);    
    Route::get('/transaksi-offline-search', ['as'=>'transaksi-offline-search','uses' => 'TransaksiOfflineController@search']);     
    Route::post('/transaksi-offline-preview', ['as'=>'transaksi-offline-preview','uses' => 'TransaksiOfflineController@preview']);
    Route::get('/transaksi-offline-delete/{id}', ['as'=>'transaksi-offline-delete','uses' => 'TransaksiOfflineController@delete']);  
    Route::post('/transaksi-offline-destroy', ['as'=>'transaksi-offline-destroy','uses' => 'TransaksiOfflineController@destroy']);
    Route::post('/transaksi-offline-list-invoice', ['as'=>'transaksi-offline-list-invoice','uses' => 'TransaksiOfflineController@listIvoice']);
    Route::post('/transaksi-offline-change-status', ['as'=>'transaksi-offline-change-status','uses' => 'TransaksiOfflineController@changeStatus']);

    // -------- Transaksi Tanpa Produk -----------------------------------------------------------
    Route::get('/transaksi-offline-other', ['as'=>'transaksi-offline-other','uses' => 'OtherTransaksiController@index']);
    Route::post('/transaksi-offline-other-store', ['as'=>'transaksi-offline-other-store','uses' => 'OtherTransaksiController@store']);
});
