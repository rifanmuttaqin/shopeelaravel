<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Toko Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->group(['prefix' => ''], function () use ($router) {
    $router->get('/',  ['as'=>'toko-index','uses' => 'TokoController@index']);
    $router->get('/create',  ['as'=>'toko-create','uses' => 'TokoController@create']);
    $router->get('/edit/{id}',  ['as'=>'toko-edit','uses' => 'TokoController@edit']);
    $router->post('/store',  ['as'=>'toko-store','uses' => 'TokoController@store']);
    $router->post('/update',  ['as'=>'toko-update','uses' => 'TokoController@update']);
    $router->post('/list',  ['as'=>'toko-list','uses' => 'TokoController@list']);
});