<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return \Cache::remember('api_stats_index', 4320, function () {
            $results = \App\Transaction::where('valid', '=', 1)
                ->where('type', '!=', 'rps')
                ->where('type', '!=', 'rpsresolves')
                ->selectRaw('COUNT(tx_index) as count, type')
                ->groupBy('type')
                ->orderBy('count', 'desc')
                ->get();

            return \App\Http\Resources\StatisticResource::collection($results);
        });
    }
}
