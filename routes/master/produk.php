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
	$router->get('/',  ['as'=>'produk','uses' => 'ProdukController@index']);
	$router->get('/create',  ['as'=>'produk-create','uses' => 'ProdukController@create']);
	$router->post('/store',  ['as'=>'produk-store','uses' => 'ProdukController@store']);

	$router->get('/produk-show/{id}',  ['as'=>'produk-show','uses' => 'ProdukController@show']);
	$router->get('/produk-edit/{produk}',  ['as'=>'produk-edit','uses' => 'ProdukController@edit']);
	$router->get('/produk-delete/{produk}',  ['as'=>'produk-delete','uses' => 'ProdukController@destroy']);
	$router->put('/produk-update/{produk}',  ['as'=>'produk-update','uses' => 'ProdukController@update']);

});

// -------- PRODUK ----------------------------------------------------------