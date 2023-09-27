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
    $router->post('/cashflowcomponent/list',  ['as'=>'cashflow-list','uses' => 'CashFlowComponentController@list']);
    $router->get('/cashflowcomponent/show/{cashFlowComponent}',  ['as'=>'cash-flow-component-show','uses' => 'CashFlowComponentController@show']);


    $router->get('/cashflowtransaction',  ['as'=>'cash-flow-transaction','uses' => 'CashFlowTransactionController@index']);
    $router->post('/cashflowtransaction/store',  ['as'=>'cash-flow-transaction-store','uses' => 'CashFlowTransactionController@store']);
    $router->delete('/cashflowtransaction/delete/{cashFlowTransaction}',  ['as'=>'cash-flow-transaction-delete','uses' => 'CashFlowTransactionController@destroy']);


});