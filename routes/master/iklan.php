<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->group(['prefix' => ''], function () use ($router) {
	$router->get('/',  ['as'=>'index-iklan','uses' => 'TopUpiklanController@index']);
	$router->post('/store',  ['as'=>'store-iklan','uses' => 'TopUpiklanController@store']);
	$router->post('/destroy',  ['as'=>'destroy-iklan','uses' => 'TopUpiklanController@destroy']);
      $router->get('/fiter-date',['as'=>'filter-date-iklan','uses'=> 'TopUpiklanController@filterDate']);
});