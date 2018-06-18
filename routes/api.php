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

Route::get('/assets/{type?}', [
    'as' => 'api.assets.index',
    'uses' => 'Api\AssetsController@index',
]);

Route::get('/blocks', [
    'as' => 'api.blocks.index',
    'uses' => 'Api\BlocksController@index',
]);

Route::get('/messages', [
    'as' => 'api.messages.index',
    'uses' => 'Api\MessagesController@index',
]);

Route::get('/mempool', [
    'as' => 'api.mempool.index',
    'uses' => 'Api\MempoolController@index',
]);

Route::get('/transactions/{type?}', [
    'as' => 'api.transactions.index',
    'uses' => 'Api\TransactionsController@index',
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

Route::get('/charts/assets/{asset_name}/related-assets', [
    'as' => 'api.charts.assets.relatedAssets',
    'uses' => 'Api\AssetChartsController@relatedAssets',
]);

Route::get('/charts/assets/{asset_name}/active-addresses', [
    'as' => 'api.charts.assets.activeAddresses',
    'uses' => 'Api\AssetChartsController@activeAddresses',
]);

Route::get('/charts/assets/{asset_name}/most-active-addresses', [
    'as' => 'api.charts.assets.mostActiveAddresses',
    'uses' => 'Api\AssetChartsController@mostActiveAddresses',
]);

Route::get('/charts/{asset_name}/top-senders', [
    'as' => 'api.charts.assets.topSenders',
    'uses' => 'Api\AssetChartsController@topSenders',
]);

Route::get('/charts/{asset_name}/top-senders-quantity', [
    'as' => 'api.charts.assets.topSendersQuantity',
    'uses' => 'Api\AssetChartsController@topSendersQuantity',
]);

Route::get('/charts/{asset_name}/unique-sends', [
    'as' => 'api.charts.assets.uniqueSends',
    'uses' => 'Api\AssetChartsController@uniqueSends',
]);

Route::get('/charts/{asset_name}/tokens-sent', [
    'as' => 'api.charts.assets.tokensSent',
    'uses' => 'Api\AssetChartsController@tokensSent',
]);

Route::get('/charts/{asset_name}/top-traders', [
    'as' => 'api.charts.assets.topTraders',
    'uses' => 'Api\AssetChartsController@topTraders',
]);

Route::get('/charts/{asset_name}/top-traders-quantity', [
    'as' => 'api.charts.assets.topTradersQuantity',
    'uses' => 'Api\AssetChartsController@topTradersQuantity',
]);

Route::get('/charts/{asset_name}/unique-trades', [
    'as' => 'api.charts.assets.uniqueTrades',
    'uses' => 'Api\AssetChartsController@uniqueTrades',
]);

Route::get('/charts/{asset_name}/tokens-traded', [
    'as' => 'api.charts.assets.tokensTraded',
    'uses' => 'Api\AssetChartsController@tokensTraded',
]);

Route::get('/charts/active-assets', [
    'as' => 'api.charts.activeAssets',
    'uses' => 'Api\ChartsController@showActiveAssets',
]);

Route::get('/charts/block-share', [
    'as' => 'api.charts.blockShare',
    'uses' => 'Api\ChartsController@showBlockShare',
]);

Route::get('/charts/btc-burned', [
    'as' => 'api.charts.btcBurned',
    'uses' => 'Api\ChartsController@showBtcBurned',
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

Route::get('/charts/gas-fees', [
    'as' => 'api.charts.gasFees',
    'uses' => 'Api\ChartsController@showGasFees',
]);

Route::get('/charts/registration-fee', [
    'as' => 'api.charts.registrationFee',
    'uses' => 'Api\ChartsController@showRegistrationFee',
]);

Route::get('/charts/messages', [
    'as' => 'api.charts.messages',
    'uses' => 'Api\ChartsController@showMessages',
]);

Route::get('/charts/orders', [
    'as' => 'api.charts.orders',
    'uses' => 'Api\ChartsController@showOrders',
]);

Route::get('/charts/sends', [
    'as' => 'api.charts.sends',
    'uses' => 'Api\ChartsController@showSends',
]);

Route::get('/charts/most-sends', [
    'as' => 'api.charts.mostSends',
    'uses' => 'Api\ChartsController@showMostSends',
]);

Route::get('/charts/transactions', [
    'as' => 'api.charts.transactions',
    'uses' => 'Api\ChartsController@showTransactions',
]);

Route::get('/charts/transaction-data', [
    'as' => 'api.charts.transactionSize',
    'uses' => 'Api\ChartsController@showTransactionSize',
]);

Route::get('/charts/average-burn-rate', [
    'as' => 'api.charts.areaRange.burnRate',
    'uses' => 'Api\AreaRangeChartsController@showBurnRate',
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