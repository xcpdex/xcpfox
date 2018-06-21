<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAddresses(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_addresses_' . $group_by, 4320, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Address::selectRaw('DATE(confirmed_at) as date, COUNT(*) as count')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Address::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(*) as count')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Address::selectRaw('YEAR(confirmed_at) as year, COUNT(*) as count')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showActiveAddresses(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_addresses_active_' . $group_by, 4320, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Balance::where('asset', '!=', 'BTC')
                        ->selectRaw('DATE(confirmed_at) as date, COUNT(DISTINCT address) as count')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Balance::where('asset', '!=', 'BTC')
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(DISTINCT address) as count')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Balance::where('asset', '!=', 'BTC')
                        ->selectRaw('YEAR(confirmed_at) as year, COUNT(DISTINCT address) as count')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showHodlAddresses(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_addresses_hodl_' . $group_by, 4320, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Address::has('credits')
                        ->doesntHave('debits')
                        ->selectRaw('DATE(confirmed_at) as date, COUNT(*) as count')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Address::has('credits')
                        ->doesntHave('debits')
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(*) as count')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Address::has('credits')
                        ->doesntHave('debits')
                        ->selectRaw('YEAR(confirmed_at) as year, COUNT(*) as count')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAssets(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year',
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_assets_' . $group_by, 4320, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Asset::where('asset_name', '!=', 'BTC')
                        ->selectRaw('DATE(confirmed_at) as date, COUNT(*) as count')->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Asset::where('asset_name', '!=', 'BTC')
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(*) as count')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Asset::where('asset_name', '!=', 'BTC')
                        ->selectRaw('YEAR(confirmed_at) as year, COUNT(*) as count')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showActiveAssets(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_assets_active_' . $group_by, 4320, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Balance::where('asset', '!=', 'BTC')
                        ->selectRaw('DATE(confirmed_at) as date, COUNT(DISTINCT asset) as count')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Balance::where('asset', '!=', 'BTC')
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(DISTINCT asset) as count')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Balance::where('asset', '!=', 'BTC')
                        ->selectRaw('YEAR(confirmed_at) as year, COUNT(DISTINCT asset) as count')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBlockShare(Request $request)
    {
        return \Cache::remember('api_charts_block_percent', 4320, function() {
            $blocks = \App\Block::whereNotNull('processed_at')
                ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, SUM(tx_count) as tx_count')
                ->groupBy('month', 'year')
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            foreach($blocks as $block)
            {
                $confirmed_at = $block->year . '-' .  str_pad($block->month, 2, '0', STR_PAD_LEFT);
                $transaction_count = \App\Transaction::where('confirmed_at', 'like', $confirmed_at . '%')->count();
                $percentage = round($transaction_count / $block->tx_count * 100, 4);

                $data[] = [$confirmed_at, $percentage];
            }

            return [
                'data' => $data
            ];
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBtcBurned(Request $request)
    {
        return \Cache::remember('api_charts_btc_burned', 4320, function() {
            $results = \App\Burn::selectRaw('DATE(confirmed_at) as date, SUM(burned) as quantity')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            return \App\Http\Resources\QuantityResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFees(Request $request)
    {
        $request->validate([
            'currency' => 'sometimes|in:BTC,USD',
            'group_by' => 'sometimes|in:date,month,year',
        ]);

        $currency = $request->input('currency', 'BTC');
        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_fees_' . $currency . '_' . $group_by, 4320, function() use($currency, $group_by) {
            $fee = $currency === 'BTC' ? 'fee' : 'fee_usd';
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('DATE(confirmed_at) as date, SUM(' . $fee . ') as fees')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, SUM(' . $fee . ') as fees')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('YEAR(confirmed_at) as year, SUM(' . $fee . ') as fees')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\FeeResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAverageFee(Request $request)
    {
        $request->validate([
            'currency' => 'sometimes|in:BTC,USD',
            'group_by' => 'sometimes|in:date,month,year',
        ]);

        $currency = $request->input('currency', 'BTC');
        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_average_fee_' . $currency . '_' . $group_by, 4320, function() use($currency, $group_by) {
            $fee = $currency === 'BTC' ? 'fee' : 'fee_usd';
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('DATE(confirmed_at) as date, AVG(' . $fee . ') as fees')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, AVG(' . $fee . ') as fees')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('YEAR(confirmed_at) as year, AVG(' . $fee . ') as fees')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\FeeResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFeeRates(Request $request)
    {
        return \Cache::remember('api_charts_fee_rates', 4320, function() {
            $results = \App\Transaction::whereNotNull('processed_at')
                ->where('confirmed_at', '>', \Carbon\Carbon::now()->subDays(1))
                ->selectRaw('COUNT(*) as count, ROUND(fee / size) as category')
                ->groupBy('category')
                ->orderBy('category', 'asc')
                ->get();

            return \App\Http\Resources\CategoryResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showGasFees(Request $request)
    {
        $request->validate([
            'currency' => 'sometimes|in:XCP,USD',
            'group_by' => 'sometimes|in:date,month,year',
        ]);

        $currency = $request->input('currency', 'XCP');
        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_gas_fees_' . $currency . '_' . $group_by, 4320, function() use($currency, $group_by) {
            $quantity = $currency === 'XCP' ? 'quantity' : 'quantity_usd';

            switch($group_by)
            {
                case 'date':
                    $results = \App\Debit::where('action', 'like', '% fee')
                        ->selectRaw('DATE(confirmed_at) as date, SUM(' . $quantity . ') as quantity')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Debit::where('action', 'like', '% fee')
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, SUM(' . $quantity . ') as quantity')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Debit::where('action', 'like', '% fee')
                        ->selectRaw('YEAR(confirmed_at) as year, SUM(' . $quantity . ') as quantity')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\QuantityResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMessages(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_messages_' . $group_by, 4320, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Message::selectRaw('DATE(confirmed_at) as date, COUNT(*) as count')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Message::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(*) as count')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Message::selectRaw('YEAR(confirmed_at) as year, COUNT(*) as count')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showOrders(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_orders_' . $group_by, 4320, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Order::selectRaw('DATE(confirmed_at) as date, COUNT(*) as count')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Order::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(*) as count')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Order::selectRaw('YEAR(confirmed_at) as year, COUNT(*) as count')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationFee(Request $request)
    {
        $request->validate([
            'currency' => 'sometimes|in:XCP,USD',
            'group_by' => 'sometimes|in:date,month,year',
        ]);

        $currency = $request->input('currency', 'XCP');
        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_registration_fee_' . $currency . '_' . $group_by, 4320, function() use($currency, $group_by) {
            $quantity = $currency === 'XCP' ? 'quantity' : 'quantity_usd';
            switch($group_by)
            {
                case 'date':
                    $results = \App\Debit::where('action', '=', 'issuance fee')
                        ->selectRaw('DATE(confirmed_at) as date, AVG(' . $quantity . ') as fees')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Debit::where('action', '=', 'issuance fee')
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, AVG(' . $quantity . ') as fees')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Debit::where('action', '=', 'issuance fee')
                        ->selectRaw('YEAR(confirmed_at) as year, AVG(' . $quantity . ') as fees')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\FeeResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSends(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_sends_' . $group_by, 4320, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Send::selectRaw('DATE(confirmed_at) as date, COUNT(*) as count')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Send::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(*) as count')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Send::selectRaw('YEAR(confirmed_at) as year, COUNT(*) as count')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMostSends(Request $request)
    {
        return \Cache::remember('api_charts_most_sends', 4320, function() {
            $results = \App\Send::selectRaw('COUNT(*) as count, asset as category')
                ->groupBy('category')
                ->orderBy('count', 'desc')
                ->take(20)
                ->get();

            return \App\Http\Resources\CategoryResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTransactions(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_transactions_' . $group_by, 4320, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::selectRaw('DATE(confirmed_at) as date, COUNT(*) as count')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(*) as count')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Transaction::selectRaw('YEAR(confirmed_at) as year, COUNT(*) as count')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTransactionSize(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_charts_transaction_size_' . $group_by, 4320, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('DATE(confirmed_at) as date, SUM(size) as size')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, SUM(size) as size')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('YEAR(confirmed_at) as year, SUM(size) as size')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\SizeResource::collection($results);
        });
    }
}
