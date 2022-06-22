<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Ekspedisi Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->group(['prefix' => ''], function () use ($router) {
	$router->get('/',  ['as'=>'index-ekspedisi','uses' => 'EkspedisiController@index']);
});