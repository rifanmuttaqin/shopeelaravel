<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->group(['prefix' => ''], function () use ($router) {
	$router->get('/',  ['as'=>'index-customer','uses' => 'CustomerController@index']);
	$router->post('/list',  ['as'=>'list-customer','uses' => 'CustomerController@list']);
	$router->post('/order-list',  ['as'=>'customer-order','uses' => 'CustomerController@listorder']);
	$router->get('/edit',  ['as'=>'customer-edit','uses' => 'CustomerController@edit']);
	$router->post('/update',  ['as'=>'customer-update','uses' => 'CustomerController@update']);

	$router->get('/export',  ['as'=>'customer-export','uses' => 'CustomerController@export']);
	$router->post('/do-export',  ['as'=>'customer-do-export','uses' => 'CustomerController@doExport']);


});