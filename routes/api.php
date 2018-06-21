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

Route::get('/search', 'Api\SearchController@index')->name('api.search.index');
Route::get('/statistics', 'Api\StatisticsController@index')->name('api.statistics.index');
Route::get('/balances/{address}', 'Api\BalancesController@show')->name('api.balances.show');
Route::get('/assets/{type?}', 'Api\AssetsController@index')->name('api.assets.index');
Route::get('/blocks', 'Api\BlocksController@index')->name('api.blocks.index');
Route::get('/messages', 'Api\MessagesController@index')->name('api.messages.index');
Route::get('/unconfirmed-transactions', 'Api\MempoolController@index')->name('api.mempool.index');
Route::get('/transactions/{type?}', 'Api\TransactionsController@index')->name('api.transactions.index');
Route::get('/charts/addresses', 'Api\ChartsController@showAddresses')->name('api.charts.addresses');
Route::get('/charts/active-addresses', 'Api\ChartsController@showActiveAddresses')->name('api.charts.activeAddresses');
Route::get('/charts/hodl-addresses', 'Api\ChartsController@showHodlAddresses')->name('api.charts.hodlAddresses');
Route::get('/charts/assets', 'Api\ChartsController@showAssets')->name('api.charts.assets');
Route::get('/charts/assets/{asset_name}/highest-balances', 'Api\AssetChartsController@showHighestBalances')->name('api.charts.assets.highestBalances');
Route::get('/charts/assets/{asset_name}/related-assets', 'Api\AssetChartsController@showRelatedAssets')->name('api.charts.assets.relatedAssets');
Route::get('/charts/assets/{asset_name}/active-addresses', 'Api\AssetChartsController@showActiveAddresses')->name('api.charts.assets.activeAddresses');
Route::get('/charts/assets/{asset_name}/most-active-addresses', 'Api\AssetChartsController@showMostActiveAddresses')->name('api.charts.assets.mostActiveAddresses');
Route::get('/charts/assets/{asset_name}/top-senders', 'Api\AssetChartsController@showTopSenders')->name('api.charts.assets.topSenders');
Route::get('/charts/assets/{asset_name}/top-senders-quantity', 'Api\AssetChartsController@showTopSendersQuantity')->name('api.charts.assets.topSendersQuantity');
Route::get('/charts/assets/{asset_name}/unique-sends', 'Api\AssetChartsController@showUniqueSends')->name('api.charts.assets.uniqueSends');
Route::get('/charts/assets/{asset_name}/tokens-sent', 'Api\AssetChartsController@showTokensSent')->name('api.charts.assets.tokensSent');
Route::get('/charts/assets/{asset_name}/top-traders', 'Api\AssetChartsController@showTopTraders')->name('api.charts.assets.topTraders');
Route::get('/charts/assets/{asset_name}/top-traders-quantity', 'Api\AssetChartsController@showTopTradersQuantity')->name('api.charts.assets.topTradersQuantity');
Route::get('/charts/assets/{asset_name}/unique-trades', 'Api\AssetChartsController@showUniqueTrades')->name('api.charts.assets.uniqueTrades');
Route::get('/charts/assets/{asset_name}/tokens-traded', 'Api\AssetChartsController@showTokensTraded')->name('api.charts.assets.tokensTraded');
Route::get('/charts/active-assets', 'Api\ChartsController@showActiveAssets')->name('api.charts.activeAssets');
Route::get('/charts/block-share', 'Api\ChartsController@showBlockShare')->name('api.charts.blockShare');
Route::get('/charts/btc-burned', 'Api\ChartsController@showBtcBurned')->name('api.charts.btcBurned');
Route::get('/charts/fees', 'Api\ChartsController@showFees')->name('api.charts.fees');
Route::get('/charts/average-fee', 'Api\ChartsController@showAverageFee')->name('api.charts.averageFee');
Route::get('/charts/fee-rates', 'Api\ChartsController@showFeeRates')->name('api.charts.feeRates');
Route::get('/charts/gas-fees', 'Api\ChartsController@showGasFees')->name('api.charts.gasFees');
Route::get('/charts/registration-fee', 'Api\ChartsController@showRegistrationFee')->name('api.charts.registrationFee');
Route::get('/charts/messages', 'Api\ChartsController@showMessages')->name('api.charts.messages');
Route::get('/charts/orders', 'Api\ChartsController@showOrders')->name('api.charts.orders');
Route::get('/charts/sends', 'Api\ChartsController@showSends')->name('api.charts.sends');
Route::get('/charts/most-sends', 'Api\ChartsController@showMostSends')->name('api.charts.mostSends');
Route::get('/charts/transactions', 'Api\ChartsController@showTransactions')->name('api.charts.transactions');
Route::get('/charts/transaction-data', 'Api\ChartsController@showTransactionSize')->name('api.charts.transactionSize');
Route::get('/charts/average-burn-rate', 'Api\AreaRangeChartsController@showBurnRate')->name('api.charts.areaRange.burnRate');
Route::get('/charts/average-fee-rate', 'Api\AreaRangeChartsController@showFeeRate')->name('api.charts.areaRange.feeRate');
Route::get('/charts/average-order-expiration', 'Api\AreaRangeChartsController@showOrderExpiration')->name('api.charts.areaRange.orderExpiration');
Route::get('/charts/average-transaction-size', 'Api\AreaRangeChartsController@showTransactionSize')->name('api.charts.areaRange.transactionSize');
Route::get('/charts/address-types', 'Api\PiechartsController@showAddresses')->name('api.charts.pie.addresses');
Route::get('/charts/asset-types', 'Api\PiechartsController@showAssets')->name('api.charts.pie.assets');
Route::get('/charts/block-presence', 'Api\PiechartsController@showBlocks')->name('api.charts.pie.blocks');
Route::get('/charts/message-categories', 'Api\PiechartsController@showMessages')->name('api.charts.pie.messages');
Route::get('/charts/transaction-types', 'Api\PiechartsController@showTransactions')->name('api.charts.pie.transaction');