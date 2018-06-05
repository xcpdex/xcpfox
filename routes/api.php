<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/search', [
    'as' => 'api.search.index',
    'uses' => 'Api\SearchController@index',
]);

Route::get('/statistics', [
    'as' => 'api.statistics.index',
    'uses' => 'Api\StatisticsController@index',
]);

Route::get('/blocks', [
    'as' => 'api.blocks.index',
    'uses' => 'Api\BlocksController@index',
]);

Route::get('/messages', [
    'as' => 'api.messages.index',
    'uses' => 'Api\MessagesController@index',
]);

Route::get('/transactions', [
    'as' => 'api.transactions.index',
    'uses' => 'Api\TransactionsController@index',
]);

Route::get('/transactions/{tx_type}', [
    'as' => 'api.transactions.show',
    'uses' => 'Api\TransactionsController@show',
]);

Route::get('/addresses', [
    'as' => 'api.addresses.index',
    'uses' => 'Api\AddressesController@index',
]);

Route::get('/assets', [
    'as' => 'api.assets.index',
    'uses' => 'Api\AssetsController@index',
]);

Route::get('/charts/total-issuance', [
    'as' => 'api.charts.total-issuance',
    'uses' => 'Api\ChartsController@showTotalIssuance',
]);

Route::get('/charts/total-sent', [
    'as' => 'api.charts.total-sent',
    'uses' => 'Api\ChartsController@showTotalSent',
]);

Route::get('/charts/total-sends', [
    'as' => 'api.charts.total-sends',
    'uses' => 'Api\ChartsController@showTotalSends',
]);

Route::get('/charts/average-order-expiration', [
    'as' => 'api.charts.average-order-expiration',
    'uses' => 'Api\ChartsController@showAverageOrderExpiration',
]);

Route::get('/charts/total-orders', [
    'as' => 'api.charts.total-orders',
    'uses' => 'Api\ChartsController@showTotalOrders',
]);

Route::get('/charts/total-addresses', [
    'as' => 'api.charts.total-addresses',
    'uses' => 'Api\ChartsController@showTotalAddresses',
]);

Route::get('/charts/total-assets', [
    'as' => 'api.charts.total-assets',
    'uses' => 'Api\ChartsController@showTotalAssets',
]);

Route::get('/charts/total-transactions', [
    'as' => 'api.charts.total-transactions',
    'uses' => 'Api\ChartsController@showTotalTransactions',
]);

Route::get('/charts/transaction-types', [
    'as' => 'api.charts.transaction-types',
    'uses' => 'Api\ChartsController@showTransactionTypes',
]);

Route::get('/charts/total-messages', [
    'as' => 'api.charts.total-messages',
    'uses' => 'Api\ChartsController@showTotalMessages',
]);

Route::get('/charts/message-categories', [
    'as' => 'api.charts.message-categories',
    'uses' => 'Api\ChartsController@showMessageCategories',
]);

Route::get('/charts/average-burn', [
    'as' => 'api.charts.average-burn',
    'uses' => 'Api\ChartsController@showAverageBurn',
]);

Route::get('/charts/average-burn-rate', [
    'as' => 'api.charts.average-burn-rate',
    'uses' => 'Api\ChartsController@showAverageBurnRate',
]);

Route::get('/charts/average-burn-usd', [
    'as' => 'api.charts.average-burn-usd',
    'uses' => 'Api\ChartsController@showAverageBurnUsd',
]);

Route::get('/charts/total-burn', [
    'as' => 'api.charts.total-burn',
    'uses' => 'Api\ChartsController@showTotalBurn',
]);

Route::get('/charts/total-burn-usd', [
    'as' => 'api.charts.total-burn-usd',
    'uses' => 'Api\ChartsController@showTotalBurnUsd',
]);

Route::get('/charts/total-fees', [
    'as' => 'api.charts.total-fees',
    'uses' => 'Api\ChartsController@showTotalFees',
]);

Route::get('/charts/total-fees-usd', [
    'as' => 'api.charts.total-fees-usd',
    'uses' => 'Api\ChartsController@showTotalFeesUsd',
]);

Route::get('/charts/average-fee', [
    'as' => 'api.charts.average-fee',
    'uses' => 'Api\ChartsController@showAverageFee',
]);

Route::get('/charts/average-fee-usd', [
    'as' => 'api.charts.average-fee-usd',
    'uses' => 'Api\ChartsController@showAverageFeeUsd',
]);

Route::get('/charts/average-fee-rate', [
    'as' => 'api.charts.average-fee-rate',
    'uses' => 'Api\ChartsController@showAverageFeeRate',
]);

Route::get('/charts/total-size', [
    'as' => 'api.charts.total-size',
    'uses' => 'Api\ChartsController@showTotalSize',
]);

Route::get('/charts/average-size', [
    'as' => 'api.charts.average-size',
    'uses' => 'Api\ChartsController@showAverageSize',
]);

Route::get('/charts/txs-by-type', [
    'as' => 'api.charts.txs-by-type',
    'uses' => 'Api\ChartsController@showTxsByType',
]);