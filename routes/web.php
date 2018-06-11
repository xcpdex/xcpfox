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

Route::get('/json', function () {
    $counterparty = new \JsonRPC\Client(env('CP_API'));
    $counterparty->authentication(env('CP_USER'), env('CP_PASS'));

    return $counterparty->execute('get_supply', ['asset' => 'XCP']);
});

Route::get('/home', [
    'as' => 'home',
    'uses' => 'HomeController@index',
]);

Route::get('/search', [
    'as' => 'search.index',
    'uses' => 'SearchController@index',
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

Route::get('/message/{message_index}', [
    'as' => 'messages.show',
    'uses' => 'MessagesController@show',
]);

Route::get('/transactions', [
    'as' => 'transactions.index',
    'uses' => 'TransactionsController@index',
]);

Route::get('/transactions/{type}', [
    'as' => 'transactions.typeIndex',
    'uses' => 'TransactionsController@typeIndex',
]);

Route::get('/tx/{transaction}', [
    'as' => 'transactions.show',
    'uses' => 'TransactionsController@show',
]);

Route::get('/addresses', [
    'as' => 'addresses.index',
    'uses' => 'AddressesController@index',
]);

Route::get('/address/{address}', [
    'as' => 'addresses.show',
    'uses' => 'AddressesController@show',
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

Route::get('/assets', [
    'as' => 'assets.index',
    'uses' => 'AssetsController@index',
]);

Route::get('/assets/{type}', [
    'as' => 'assets.typeIndex',
    'uses' => 'AssetsController@typeIndex',
]);

Route::get('/asset/{asset}', [
    'as' => 'assets.show',
    'uses' => 'AssetsController@show',
]);

Route::get('/leaderboard', [
    'as' => 'leaderboard.index',
    'uses' => 'LeaderboardController@index',
]);

Route::get('/docs', [
    'as' => 'docs',
    'uses' => 'PagesController@getDocs',
]);

Route::get('/docs/node-setup', [
    'as' => 'node',
    'uses' => 'PagesController@getNodeSetup',
]);

Route::get('/faq', [
    'as' => 'faq',
    'uses' => 'PagesController@getFaq',
]);

Route::get('/terms', [
    'as' => 'terms',
    'uses' => 'PagesController@getTerms',
]);

Route::get('/privacy', [
    'as' => 'privacy',
    'uses' => 'PagesController@getPrivacy',
]);

Route::get('/disclaimer', [
    'as' => 'disclaimer',
    'uses' => 'PagesController@getDisclaimer',
]);

Route::get('/chart', function () {
    return view('chart');
});

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

Route::get('/charts/transactions', [
    'as' => 'charts.transactions',
    'uses' => 'ChartsController@showTransactions',
]);

Route::get('/charts/transaction-data', [
    'as' => 'charts.transactionSize',
    'uses' => 'ChartsController@showTransactionSize',
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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
