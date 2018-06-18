<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [
    'as' => 'home',
    'uses' => 'HomeController@index',
]);

Route::get('/search', [
    'as' => 'search.index',
    'uses' => 'SearchController@index',
]);

Route::get('/address/{address}', [
    'as' => 'addresses.show',
    'uses' => 'AddressesController@show',
]);

Route::get('/assets/{type?}', [
    'as' => 'assets.index',
    'uses' => 'AssetsController@index',
]);

Route::get('/asset/{asset}', [
    'as' => 'assets.show',
    'uses' => 'AssetsController@show',
]);

Route::get('/blocks', [
    'as' => 'blocks.index',
    'uses' => 'BlocksController@index',
]);

Route::get('/block/{block}', [
    'as' => 'blocks.show',
    'uses' => 'BlocksController@show',
]);

Route::get('/messages', [
    'as' => 'messages.index',
    'uses' => 'MessagesController@index',
]);

Route::get('/message/{message}', [
    'as' => 'messages.show',
    'uses' => 'MessagesController@show',
]);

Route::get('/unconfirmed-transactions', [
    'as' => 'mempool.index',
    'uses' => 'MempoolController@index',
]);

Route::get('/transactions/{type?}', [
    'as' => 'transactions.index',
    'uses' => 'TransactionsController@index',
]);

Route::get('/tx/{transaction}', [
    'as' => 'transactions.show',
    'uses' => 'TransactionsController@show',
]);

Route::get('/leaderboard', [
    'as' => 'leaderboard.index',
    'uses' => 'LeaderboardController@index',
]);

Route::get('/charts', [
    'as' => 'charts.index',
    'uses' => 'ChartsController@index',
]);

Route::get('/charts/new-addresses', [
    'as' => 'charts.addresses',
    'uses' => 'ChartsController@showAddresses',
]);

Route::get('/charts/active-addresses', [
    'as' => 'charts.activeAddresses',
    'uses' => 'ChartsController@showActiveAddresses',
]);

Route::get('/charts/hodl-addresses', [
    'as' => 'charts.hodlAddresses',
    'uses' => 'ChartsController@showHodlAddresses',
]);

Route::get('/charts/new-assets', [
    'as' => 'charts.assets',
    'uses' => 'ChartsController@showAssets',
]);

Route::get('/charts/active-assets', [
    'as' => 'charts.activeAssets',
    'uses' => 'ChartsController@showActiveAssets',
]);

Route::get('/charts/block-share', [
    'as' => 'charts.blockShare',
    'uses' => 'ChartsController@showBlockShare',
]);

Route::get('/charts/btc-burned', [
    'as' => 'charts.btcBurned',
    'uses' => 'ChartsController@showBtcBurned',
]);

Route::get('/charts/total-fees', [
    'as' => 'charts.fees',
    'uses' => 'ChartsController@showFees',
]);

Route::get('/charts/average-fee', [
    'as' => 'charts.averageFee',
    'uses' => 'ChartsController@showAverageFee',
]);

Route::get('/charts/fee-rates', [
    'as' => 'charts.feeRates',
    'uses' => 'ChartsController@showFeeRates',
]);

Route::get('/charts/gas-fees', [
    'as' => 'charts.gasFees',
    'uses' => 'ChartsController@showGasFees',
]);

Route::get('/charts/messages', [
    'as' => 'charts.messages',
    'uses' => 'ChartsController@showMessages',
]);

Route::get('/charts/orders', [
    'as' => 'charts.orders',
    'uses' => 'ChartsController@showOrders',
]);

Route::get('/charts/registration-fee', [
    'as' => 'charts.registrationFee',
    'uses' => 'ChartsController@showRegistrationFee',
]);

Route::get('/charts/sends', [
    'as' => 'charts.sends',
    'uses' => 'ChartsController@showSends',
]);

Route::get('/charts/most-sends', [
    'as' => 'charts.mostSends',
    'uses' => 'ChartsController@showMostSends',
]);

Route::get('/charts/transactions', [
    'as' => 'charts.transactions',
    'uses' => 'ChartsController@showTransactions',
]);

Route::get('/charts/transaction-data', [
    'as' => 'charts.transactionSize',
    'uses' => 'ChartsController@showTransactionSize',
]);

Route::get('/charts/xcp-supply', [
    'as' => 'charts.xcpSupply',
    'uses' => 'ChartsController@showXcpSupply',
]);

Route::get('/charts/average-burn-rate', [
    'as' => 'charts.areaRange.burnRate',
    'uses' => 'AreaRangeChartsController@showBurnRate',
]);

Route::get('/charts/average-fee-rate', [
    'as' => 'charts.areaRange.feeRate',
    'uses' => 'AreaRangeChartsController@showFeeRate',
]);

Route::get('/charts/average-order-expiration', [
    'as' => 'charts.areaRange.orderExpiration',
    'uses' => 'AreaRangeChartsController@showOrderExpiration',
]);

Route::get('/charts/average-transaction-size', [
    'as' => 'charts.areaRange.transactionSize',
    'uses' => 'AreaRangeChartsController@showTransactionSize',
]);

Route::get('/charts/address-types', [
    'as' => 'charts.pie.addresses',
    'uses' => 'PiechartsController@showAddresses',
]);

Route::get('/charts/asset-types', [
    'as' => 'charts.pie.assets',
    'uses' => 'PiechartsController@showAssets',
]);

Route::get('/charts/block-presence', [
    'as' => 'charts.pie.blocks',
    'uses' => 'PiechartsController@showBlocks',
]);

Route::get('/charts/message-categories', [
    'as' => 'charts.pie.messages',
    'uses' => 'PiechartsController@showMessages',
]);

Route::get('/charts/transaction-types', [
    'as' => 'charts.pie.transactions',
    'uses' => 'PiechartsController@showTransactions',
]);

Route::get('/about', [
    'as' => 'about',
    'uses' => 'PagesController@getAbout',
]);

Route::get('/contact', [
    'as' => 'contact',
    'uses' => 'PagesController@getContact',
]);

Route::get('/disclaimer', [
    'as' => 'disclaimer',
    'uses' => 'PagesController@getDisclaimer',
]);

Route::get('/docs', [
    'as' => 'docs',
    'uses' => 'PagesController@getDocs',
]);

Route::get('/docs/node-setup', [
    'as' => 'node',
    'uses' => 'PagesController@getNodeSetup',
]);

Route::get('/docs/protocol-specification', [
    'as' => 'protocol',
    'uses' => 'PagesController@getProtocolSpecification',
]);

Route::get('/faq', [
    'as' => 'faq',
    'uses' => 'PagesController@getFaq',
]);

Route::get('/privacy', [
    'as' => 'privacy',
    'uses' => 'PagesController@getPrivacy',
]);

Route::get('/terms', [
    'as' => 'terms',
    'uses' => 'PagesController@getTerms',
]);

Route::get('/sitemap.xml', [
    'as' => 'sitemaps.index',
    'uses' => 'SitemapsController@index',
]);

Route::get('/sitemap/routes.xml', [
    'as' => 'sitemaps.routes',
    'uses' => 'SitemapsController@routes',
]);

Route::get('/sitemap/{type}-{page}.xml', [
    'as' => 'sitemaps.show',
    'uses' => 'SitemapsController@show',
]);

Auth::routes();