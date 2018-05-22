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

Route::get('/chart', function () {
    return view('chart');
});

Route::get('/charts', [
    'as' => 'charts.index',
    'uses' => 'ChartsController@index',
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

Route::get('/raw', function () {
    return \App\Transaction::first()->raw;
});

Route::get('/json', function () {
    $counterparty = new \JsonRPC\Client(env('CP_API'));
    $counterparty->authentication(env('CP_USER'), env('CP_PASS'));

    $data = $counterparty->execute('get_blocks', ['block_indexes' => [500006]]);

    $messages = $data[0]['_messages'];
    usort($messages, function ($message1, $message2) {
        return $message1['command'] <=> $message2['command'];
    });

    return $messages;
});