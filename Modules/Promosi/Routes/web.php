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


Route::prefix('promosi')->group(function() {
    
    // -------- PRODUK -----------------------------------------------------------
    Route::get('/blast', ['as'=>'blast','uses' => 'BlastController@index']);
    Route::post('/blast-preview', ['as'=>'blast-preview','uses' => 'BlastController@preview']);
    Route::post('/blast-doblast', ['as'=>'blast-doblast','uses' => 'BlastController@doblast']);

    
});
