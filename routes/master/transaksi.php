<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Transaksi Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->group(['prefix' => ''], function () use ($router) {
	$router->get('/',  ['as'=>'transaksi','uses' => 'TransaksiController@index']);
	$router->get('/report',  ['as'=>'report-transaksi','uses' => 'ReportTransaksiController@index']);
	$router->get('/listpage',  ['as'=>'listpage-transaksi','uses' => 'TransaksiController@listpage']);
	$router->get('/show',  ['as'=>'show-transaksi','uses' => 'TransaksiController@detail']);
	$router->get('/delete',  ['as'=>'delete-transaksi','uses' => 'TransaksiController@delete']);
	$router->post('/import',  ['as'=>'import-transaksi','uses' => 'TransaksiController@doImport']);
	$router->post('/get-income',  ['as'=>'income-get','uses' => 'ReportTransaksiController@getTransaksiIncome']);
	$router->get('/report-grafik',  ['as'=>'report-transaksi-grafik','uses' => 'ReportTransaksiController@grafik']);
	$router->post('/show-grafik',  ['as'=>'report-transaksi-grafik-show','uses' => 'ReportTransaksiController@grafikShow']);
	$router->post('/update',  ['as'=>'transaksi-update','uses' => 'TransaksiController@update']);
	$router->post('/list',  ['as'=>'transaksi-list','uses' => 'TransaksiController@list']);
});