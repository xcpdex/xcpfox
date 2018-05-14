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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/charts/average-burn', [
    'as' => 'api.charts.average-burn',
    'uses' => 'Api\ChartsController@showAverageBurn',
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

Route::get('/blocks', function () {
    return \App\Block::selectRaw('COUNT(*) as count, DATE(confirmed_at) as date, AVG(difficulty) as difficulty')->groupBy('date')->orderBy('date', 'asc')->get();
});

Route::get('/fees', function () {
    return \App\Transaction::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, SUM(fee) as fees, SUM(fee_usd) as fees_usd')->groupBy('year')->groupBy('month')->orderBy('year')->orderBy('month')->get();
});

Route::get('/messages', function () {
    return \App\Message::selectRaw('COUNT(*) as count, YEAR(confirmed_at) as year, MONTH(confirmed_at) as month')->groupBy('year')->groupBy('month')->orderBy('year')->orderBy('month')->get();
});

Route::get('/transactions', function () {
    return \App\Transaction::selectRaw('COUNT(*) as count, YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, AVG(fee) as fee, AVG(fee_usd) as fee_usd, AVG(size) as size, AVG(inputs) as inputs, AVG(outputs) as outputs')->groupBy('year')->groupBy('month')->orderBy('year')->orderBy('month')->get();
});

Route::get('/transactions/{type}', function ($type) {
    return \App\Transaction::whereType($type)->selectRaw('COUNT(*) as count, YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, AVG(fee) as fee, AVG(size) as size, AVG(inputs) as inputs, AVG(outputs) as outputs')->groupBy('year')->groupBy('month')->orderBy('year')->orderBy('month')->get();
});
