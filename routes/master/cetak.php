<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Cetak Label Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->group(['prefix' => ''], function () use ($router) {
    $router->get('/',  ['as'=>'cetak-label','uses' => 'CetakLabelController@index']);
    $router->post('/do-cetak',  ['as'=>'do-cetak-label','uses' => 'CetakLabelController@doCetak']);
    $router->post('/preview',  ['as'=>'preview-cetak','uses' => 'CetakLabelController@preview']);
    $router->get('/history',  ['as'=>'history-cetak','uses' => 'HistoryCetakLabelController@index']);
    $router->get('/do-cetak-history/{id}',  ['as'=>'do-cetak-history','uses' => 'CetakLabelController@cetakByHistory']);
});