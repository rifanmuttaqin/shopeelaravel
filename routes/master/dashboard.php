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
	$router->post('/transaction',  ['as'=>'dashboard-transaction','uses' => 'HomeController@getTransactionInfo']);
	$router->post('/customer',  ['as'=>'dashboard-customer','uses' => 'HomeController@getCustomerInfo']);
	$router->post('/cashflow',  ['as'=>'dashboard-cashflow','uses' => 'HomeController@getCashFlow']);
	$router->post('/salesOfflineChart',  ['as'=>'dashboard-salesOfflineChart','uses' => 'HomeController@salesOfflineChart']);
	$router->post('/salesOnlineChart',  ['as'=>'dashboard-salesOnlineChart','uses' => 'HomeController@salesOnlineChart']);


});