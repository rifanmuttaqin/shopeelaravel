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
    $router->get('/cashflowcomponent',  ['as'=>'cash-flow-component','uses' => 'CashFlowComponentController@index']);
    $router->post('/cashflowcomponent/store',  ['as'=>'cash-flow-component-store','uses' => 'CashFlowComponentController@store']);
    $router->delete('/cashflowcomponent/delete/{cashFlowComponent}',  ['as'=>'cash-flow-component-delete','uses' => 'CashFlowComponentController@destroy']);
    $router->put('/cashflowcomponent/update/{cashFlowComponent}',  ['as'=>'cash-flow-component-update','uses' => 'CashFlowComponentController@update']);
});