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

    
});
