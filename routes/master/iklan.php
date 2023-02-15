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
	$router->get('/',  ['as'=>'index-iklan','uses' => 'TopUpIklanController@index']);
	$router->post('/store',  ['as'=>'store-iklan','uses' => 'TopUpIklanController@store']);
	$router->post('/destroy',  ['as'=>'destroy-iklan','uses' => 'TopUpIklanController@destroy']);
	$router->post('/gettotal',  ['as'=>'total-iklan','uses' => 'TopUpIklanController@gettotaliklan']);
    $router->get('/fiter-date',['as'=>'filter-date-iklan','uses'=> 'TopUpIklanController@filterdate']);
});