<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaRangeChartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBurnRate(Request $request)
    {
        return \Cache::remember('api_area_range_charts_burn_rate', 1440, function() {
            $results = \App\Burn::selectRaw('DATE(confirmed_at) as date, AVG(earned / burned) as average, MIN(earned / burned) as minimum, MAX(earned / burned) as maximum')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            return \App\Http\Resources\AreaRangeResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFeeRate(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_area_range_charts_fee_rate_' . $group_by, 1440, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('DATE(confirmed_at) as date, AVG(fee / size) as average, MIN(fee / size) as minimum, MAX(fee / size) as maximum')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, AVG(fee / size) as average, MIN(fee / size) as minimum, MAX(fee / size) as maximum')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('YEAR(confirmed_at) as year, AVG(fee / size) as average, MIN(fee / size) as minimum, MAX(fee / size) as maximum')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\AreaRangeResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showOrderExpiration(Request $request)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

        return \Cache::remember('api_area_range_charts_order_expiration_' . $group_by, 1440, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Order::selectRaw('DATE(confirmed_at) as date, AVG(expiration) as average, MIN(expiration) as minimum, MAX(expiration) as maximum')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Order::selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, AVG(expiration) as average, MIN(expiration) as minimum, MAX(expiration) as maximum')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Order::selectRaw('YEAR(confirmed_at) as year, AVG(expiration) as average, MIN(expiration) as minimum, MAX(expiration) as maximum')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\AreaRangeResource::collection($results);
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

        return \Cache::remember('api_area_range_charts_transaction_size_' . $group_by, 1440, function() use($group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('DATE(confirmed_at) as date, AVG(size) as average, MIN(size) as minimum, MAX(size) as maximum')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, AVG(size) as average, MIN(size) as minimum, MAX(size) as maximum')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = \App\Transaction::whereNotNull('processed_at')
                        ->selectRaw('YEAR(confirmed_at) as year, AVG(size) as average, MIN(size) as minimum, MAX(size) as maximum')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\AreaRangeResource::collection($results);
        });
    }
}