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

Route::get('/charts/address-types', [
    'as' => 'api.charts.pie.addresses',
    'uses' => 'Api\PiechartsController@showAddresses',
]);

Route::get('/charts/asset-types', [
    'as' => 'api.charts.pie.assets',
    'uses' => 'Api\PiechartsController@showAssets',
]);

Route::get('/charts/block-presence', [
    'as' => 'api.charts.pie.blocks',
    'uses' => 'Api\PiechartsController@showBlocks',
]);

Route::get('/charts/message-categories', [
    'as' => 'api.charts.pie.messages',
    'uses' => 'Api\PiechartsController@showMessages',
]);

Route::get('/charts/transaction-types', [
    'as' => 'api.charts.pie.transactions',
    'uses' => 'Api\PiechartsController@showTransactions',
]);

Route::get('/charts/addresses/{asset_name}', [
    'as' => 'api.assetAddresses.chart',
    'uses' => 'Api\AssetAddressesController@chart',
]);

Route::get('/assets', [
    'as' => 'api.assets.index',
    'uses' => 'Api\AssetsController@index',
]);

Route::get('/assets/{asset_type}', [
    'as' => 'api.assets.show',
    'uses' => 'Api\AssetsController@show',
]);

Route::get('/charts/addresses', [
    'as' => 'api.charts.addresses',
    'uses' => 'Api\ChartsController@showAddresses',
]);

Route::get('/charts/active-addresses', [
    'as' => 'api.charts.activeAddresses',
    'uses' => 'Api\ChartsController@showActiveAddresses',
]);

Route::get('/charts/hodl-addresses', [
    'as' => 'api.charts.hodlAddresses',
    'uses' => 'Api\ChartsController@showHodlAddresses',
]);

Route::get('/charts/assets', [
    'as' => 'api.charts.assets',
    'uses' => 'Api\ChartsController@showAssets',
]);

Route::get('/charts/active-assets', [
    'as' => 'api.charts.activeAssets',
    'uses' => 'Api\ChartsController@showActiveAssets',
]);

Route::get('/charts/block-share', [
    'as' => 'api.charts.blockShare',
    'uses' => 'Api\ChartsController@showBlockShare',
]);

Route::get('/charts/messages', [
    'as' => 'api.charts.messages',
    'uses' => 'Api\ChartsController@showMessages',
]);

Route::get('/charts/orders', [
    'as' => 'api.charts.orders',
    'uses' => 'Api\ChartsController@showOrders',
]);

Route::get('/charts/registration-fee', [
    'as' => 'api.charts.registrationFee',
    'uses' => 'Api\ChartsController@showRegistrationFee',
]);

Route::get('/charts/sends', [
    'as' => 'api.charts.sends',
    'uses' => 'Api\ChartsController@showSends',
]);

Route::get('/charts/transactions', [
    'as' => 'api.charts.transactions',
    'uses' => 'Api\ChartsController@showTransactions',
]);

Route::get('/charts/transaction-data', [
    'as' => 'api.charts.transactionSize',
    'uses' => 'Api\ChartsController@showTransactionSize',
]);

Route::get('/charts/fees', [
    'as' => 'api.charts.fees',
    'uses' => 'Api\ChartsController@showFees',
]);

Route::get('/charts/average-fee', [
    'as' => 'api.charts.averageFee',
    'uses' => 'Api\ChartsController@showAverageFee',
]);

Route::get('/charts/fee-rates', [
    'as' => 'api.charts.feeRates',
    'uses' => 'Api\ChartsController@showFeeRates',
]);

Route::get('/charts/average-fee-rate', [
    'as' => 'api.charts.areaRange.feeRate',
    'uses' => 'Api\AreaRangeChartsController@showFeeRate',
]);

Route::get('/charts/average-order-expiration', [
    'as' => 'api.charts.areaRange.orderExpiration',
    'uses' => 'Api\AreaRangeChartsController@showOrderExpiration',
]);

Route::get('/charts/average-transaction-size', [
    'as' => 'api.charts.areaRange.transactionSize',
    'uses' => 'Api\AreaRangeChartsController@showTransactionSize',
]);

Route::get('/charts/balance-history/{address}/{asset}', [
    'as' => 'api.charts.balance-history',
    'uses' => 'Api\ChartsController@showBalanceHistory',
]);

Route::get('/charts/total-issuance', [
    'as' => 'api.charts.total-issuance',
    'uses' => 'Api\ChartsController@showTotalIssuance',
]);

Route::get('/charts/total-sent', [
    'as' => 'api.charts.total-sent',
    'uses' => 'Api\ChartsController@showTotalSent',
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

Route::get('/charts/txs-by-type', [
    'as' => 'api.charts.txs-by-type',
    'uses' => 'Api\ChartsController@showTxsByType',
]);