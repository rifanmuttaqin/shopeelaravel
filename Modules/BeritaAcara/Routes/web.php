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

Route::prefix('beritaacara')->group(function() {

    // -------- PRODUK -----------------------------------------------------------
    Route::get('/', ['as'=>'beritaacara','uses' => 'BeritaAcaraController@index']);
    Route::get('/beritaacara-create', ['as'=>'beritaacara-create','uses' => 'BeritaAcaraController@create']);
    Route::get('/beritaacara-search', ['as'=>'beritaacara-search','uses' => 'BeritaAcaraController@search']);
    Route::post('/beritaacara-store', ['as'=>'beritaacara-store','uses' => 'BeritaAcaraController@store']);
    Route::get('/beritaacara-show/{id}', ['as'=>'beritaacara-show','uses' => 'BeritaAcaraController@show']);
    Route::get('/beritaacara-edit/{id}', ['as'=>'beritaacara-edit','uses' => 'BeritaAcaraController@edit']);
    Route::get('/beritaacara-delete/{id}', ['as'=>'beritaacara-delete','uses' => 'BeritaAcaraController@delete']);
    Route::post('/beritaacara-store', ['as'=>'beritaacara-store','uses' => 'BeritaAcaraController@store']);
    Route::post('/beritaacara-update', ['as'=>'beritaacara-update','uses' => 'BeritaAcaraController@update']);
    Route::post('/beritaacara-destroy', ['as'=>'beritaacara-destroy','uses' => 'BeritaAcaraController@destroy']);
    Route::post('/beritaacara-list', ['as'=>'beritaacara-list','uses' => 'BeritaAcaraController@list']); 

    
});
