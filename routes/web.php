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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/export/credits', 'ExportController@credits');
Route::get('/search', 'SearchController@index')->name('search.index');
Route::get('/address/{address}', 'AddressesController@show')->name('addresses.show');
Route::get('/address/{type?}', 'AddressesController@index')->name('addresses.index');
Route::get('/assets', 'AssetsController@index')->name('assets.index');
Route::get('/asset/{asset}', 'AssetsController@show')->name('assets.show');
Route::get('/blocks', 'BlocksController@index')->name('blocks.index');
Route::get('/block/{block}', 'BlocksController@show')->name('blocks.show');
Route::get('/messages', 'MessagesController@index')->name('messages.index');
Route::get('/message/{message}', 'MessagesController@show')->name('messages.show');
Route::get('/unconfirmed-transactions', 'MempoolController@index')->name('mempool.index');
Route::get('/transactions/{type?}', 'TransactionsController@index')->name('transactions.index');
Route::get('/tx/{transaction}', 'TransactionsController@show')->name('transactions.show');
Route::get('/leaderboard', 'LeaderboardController@index')->name('leaderboard.index');
Route::get('/charts', 'ChartsController@index')->name('charts.index');
Route::get('/charts/new-addresses', 'ChartsController@showAddresses')->name('charts.addresses');
Route::get('/charts/active-addresses', 'ChartsController@showActiveAddresses')->name('charts.activeAddresses');
Route::get('/charts/hodl-addresses', 'ChartsController@showHodlAddresses')->name('charts.hodlAddresses');
Route::get('/charts/new-assets', 'ChartsController@showAssets')->name('charts.assets');
Route::get('/charts/active-assets', 'ChartsController@showActiveAssets')->name('charts.activeAssets');
Route::get('/charts/block-share', 'ChartsController@showBlockShare')->name('charts.blockShare');
Route::get('/charts/btc-burned', 'ChartsController@showBtcBurned')->name('charts.btcBurned');
Route::get('/charts/total-fees', 'ChartsController@showFees')->name('charts.fees');
Route::get('/charts/average-fee', 'ChartsController@showAverageFee')->name('charts.averageFee');
Route::get('/charts/fee-rates', 'ChartsController@showFeeRates')->name('charts.feeRates');
Route::get('/charts/gas-rates', 'ChartsController@showGasFees')->name('charts.gasFees');
Route::get('/charts/messages', 'ChartsController@showMessages')->name('charts.messages');
Route::get('/charts/orders', 'ChartsController@showOrders')->name('charts.orders');
Route::get('/charts/registration-fee', 'ChartsController@showRegistrationFee')->name('charts.registrationFee');
Route::get('/charts/sends', 'ChartsController@showSends')->name('charts.sends');
Route::get('/charts/most-sends', 'ChartsController@showMostSends')->name('charts.mostSends');
Route::get('/charts/transactions', 'ChartsController@showTransactions')->name('charts.transactions');
Route::get('/charts/transaction-data', 'ChartsController@showTransactionSize')->name('charts.transactionSize');
Route::get('/charts/xcp-supply', 'ChartsController@showXcpSupply')->name('charts.xcpSupply');
Route::get('/charts/average-burn-rate', 'AreaRangeChartsController@showBurnRate')->name('charts.areaRange.burnRate');
Route::get('/charts/average-fee-rate', 'AreaRangeChartsController@showFeeRate')->name('charts.areaRange.feeRate');
Route::get('/charts/average-order-expiration', 'AreaRangeChartsController@showOrderExpiration')->name('charts.areaRange.orderExpiration');
Route::get('/charts/average-transaction-size', 'AreaRangeChartsController@showTransactionSize')->name('charts.areaRange.transactionSize');
Route::get('/charts/address-types', 'PiechartsController@showAddresses')->name('charts.pie.addresses');
Route::get('/charts/asset-types', 'PiechartsController@showAssets')->name('charts.pie.assets');
Route::get('/charts/block-presence', 'PiechartsController@showBlocks')->name('charts.pie.blocks');
Route::get('/charts/message-categories', 'PiechartsController@showMessages')->name('charts.pie.messages');
Route::get('/charts/transaction-types', 'PiechartsController@showTransactions')->name('charts.pie.transactions');
Route::get('/about', 'PagesController@showAbout')->name('about');
Route::get('/contact', 'PagesController@showContact')->name('contact');
Route::get('/disclaimer', 'PagesController@showDisclaimer')->name('disclaimer');
Route::get('/docs', 'PagesController@showDocs')->name('docs');
Route::get('/docs/node-setup', 'PagesController@showNodeSetup')->name('node');
Route::get('/docs/protocol-specification', 'PagesController@showProtocolSpecification')->name('protocol');
Route::get('/faq', 'PagesController@showFaq')->name('faq');
Route::get('/privacy', 'PagesController@showPrivacy')->name('privacy');
Route::get('/terms', 'PagesController@showTerms')->name('terms');
Route::get('/sitemap.xml', 'SitemapsController@index')->name('sitemaps.index');
Route::get('/sitemap/routes.xml', 'SitemapsController@routes')->name('sitemaps.routes');
Route::get('/sitemap/{type}-{page}.xml', 'SitemapsController@show')->name('sitemaps.show');

Auth::routes();