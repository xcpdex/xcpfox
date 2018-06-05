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
    return $counterparty->execute('get_blocks', ['block_indexes' => ['488471', '488472']]);
});

Route::get('/json2', function () {
    $counterparty = new \JsonRPC\Client(env('CP_API'));
    $counterparty->authentication(env('CP_USER'), env('CP_PASS'));
    return $counterparty->execute('get_blocks', ['block_indexes' => range(488470,488480)]);
});

Route::get('/json3', function () {
    $counterparty = new \JsonRPC\Client(env('CP_API'));
    $counterparty->authentication(env('CP_USER'), env('CP_PASS'));
    return $counterparty->execute('get_blocks', ['block_indexes' => range(488471,488472)]);
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

Route::get('/assets', [
    'as' => 'assets.index',
    'uses' => 'AssetsController@index',
]);

Route::get('/asset/{asset}', [
    'as' => 'assets.show',
    'uses' => 'AssetsController@show',
]);

Route::get('/sends', [
    'as' => 'sends.index',
    'uses' => 'SendsController@index',
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

Route::get('/chart', function () {
    return view('chart');
});

Route::get('/charts', [
    'as' => 'charts.index',
    'uses' => 'ChartsController@index',
]);

Route::get('/charts/cumulative-issuance', [
    'as' => 'charts.cumulative-issuance',
    'uses' => 'ChartsController@showCumulativeIssuance',
]);

Route::get('/charts/total-issuance', [
    'as' => 'charts.total-issuance',
    'uses' => 'ChartsController@showTotalIssuance',
]);

Route::get('/charts/total-sends', [
    'as' => 'charts.total-sends',
    'uses' => 'ChartsController@showTotalSends',
]);

Route::get('/charts/cumulative-sends', [
    'as' => 'charts.cumulative-sends',
    'uses' => 'ChartsController@showCumulativeSends',
]);

Route::get('/charts/average-order-expiration', [
    'as' => 'charts.average-order-expiration',
    'uses' => 'ChartsController@showAverageOrderExpiration',
]);

Route::get('/charts/total-sent', [
    'as' => 'charts.total-sent',
    'uses' => 'ChartsController@showTotalSent',
]);

Route::get('/charts/cumulative-sent', [
    'as' => 'charts.cumulative-sent',
    'uses' => 'ChartsController@showCumulativeSent',
]);

Route::get('/charts/total-orders', [
    'as' => 'charts.total-orders',
    'uses' => 'ChartsController@showTotalOrders',
]);

Route::get('/charts/cumulative-orders', [
    'as' => 'charts.cumulative-orders',
    'uses' => 'ChartsController@showCumulativeOrders',
]);

Route::get('/charts/total-addresses', [
    'as' => 'charts.total-addresses',
    'uses' => 'ChartsController@showTotalAddresses',
]);

Route::get('/charts/cumulative-addresses', [
    'as' => 'charts.cumulative-addresses',
    'uses' => 'ChartsController@showCumulativeAddresses',
]);

Route::get('/charts/total-assets', [
    'as' => 'charts.total-assets',
    'uses' => 'ChartsController@showTotalAssets',
]);

Route::get('/charts/cumulative-assets', [
    'as' => 'charts.cumulative-assets',
    'uses' => 'ChartsController@showCumulativeAssets',
]);

Route::get('/charts/total-messages', [
    'as' => 'charts.total-messages',
    'uses' => 'ChartsController@showTotalMessages',
]);

Route::get('/charts/message-categories', [
    'as' => 'charts.message-categories',
    'uses' => 'ChartsController@showMessageCategories',
]);

Route::get('/charts/cumulative-messages', [
    'as' => 'charts.cumulative-messages',
    'uses' => 'ChartsController@showCumulativeMessages',
]);

Route::get('/charts/total-transactions', [
    'as' => 'charts.total-transactions',
    'uses' => 'ChartsController@showTotalTransactions',
]);

Route::get('/charts/transaction-types', [
    'as' => 'charts.transaction-types',
    'uses' => 'ChartsController@showTransactionTypes',
]);

Route::get('/charts/cumulative-transactions', [
    'as' => 'charts.cumulative-transactions',
    'uses' => 'ChartsController@showCumulativeTransactions',
]);

Route::get('/charts/xcp-price', [
    'as' => 'charts.xcp-price',
    'uses' => 'ChartsController@showXcpPrice',
]);

Route::get('/charts/xcp-volume', [
    'as' => 'charts.xcp-volume',
    'uses' => 'ChartsController@showXcpVolume',
]);

Route::get('/charts/xcp-market-cap', [
    'as' => 'charts.xcp-market-cap',
    'uses' => 'ChartsController@showXcpMarketCap',
]);

Route::get('/charts/txs-by-type', [
    'as' => 'charts.txs-by-type',
    'uses' => 'ChartsController@showTxsByType',
]);

Route::get('/charts/average-burn-rate', [
    'as' => 'charts.average-burn-rate',
    'uses' => 'ChartsController@showAverageBurnRate',
]);

Route::get('/charts/average-burn', [
    'as' => 'charts.average-burn',
    'uses' => 'ChartsController@showAverageBurn',
]);

Route::get('/charts/average-burn-usd', [
    'as' => 'charts.average-burn-usd',
    'uses' => 'ChartsController@showAverageBurnUsd',
]);

Route::get('/charts/total-burn', [
    'as' => 'charts.total-burn',
    'uses' => 'ChartsController@showTotalBurn',
]);

Route::get('/charts/total-burn-usd', [
    'as' => 'charts.total-burn-usd',
    'uses' => 'ChartsController@showTotalBurnUsd',
]);

Route::get('/charts/cumulative-burn', [
    'as' => 'charts.cumulative-burn',
    'uses' => 'ChartsController@showCumulativeBurn',
]);

Route::get('/charts/cumulative-burn-usd', [
    'as' => 'charts.cumulative-burn-usd',
    'uses' => 'ChartsController@showCumulativeBurnUsd',
]);

Route::get('/charts/cumulative-fees', [
    'as' => 'charts.cumulative-fees',
    'uses' => 'ChartsController@showCumulativeFees',
]);

Route::get('/charts/cumulative-fees-usd', [
    'as' => 'charts.cumulative-fees-usd',
    'uses' => 'ChartsController@showCumulativeFeesUsd',
]);

Route::get('/charts/total-fees', [
    'as' => 'charts.total-fees',
    'uses' => 'ChartsController@showTotalFees',
]);

Route::get('/charts/total-fees-usd', [
    'as' => 'charts.total-fees-usd',
    'uses' => 'ChartsController@showTotalFeesUsd',
]);

Route::get('/charts/average-fee', [
    'as' => 'charts.average-fee',
    'uses' => 'ChartsController@showAverageFee',
]);

Route::get('/charts/average-fee-usd', [
    'as' => 'charts.average-fee-usd',
    'uses' => 'ChartsController@showAverageFeeUsd',
]);

Route::get('/charts/average-fee-rate', [
    'as' => 'charts.average-fee-rate',
    'uses' => 'ChartsController@showAverageFeeRate',
]);

Route::get('/charts/cumulative-size', [
    'as' => 'charts.cumulative-size',
    'uses' => 'ChartsController@showCumulativeSize',
]);

Route::get('/charts/total-size', [
    'as' => 'charts.total-size',
    'uses' => 'ChartsController@showTotalSize',
]);

Route::get('/charts/average-size', [
    'as' => 'charts.average-size',
    'uses' => 'ChartsController@showAverageSize',
]);