<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PiechartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAddresses(Request $request)
    {
        return \Cache::remember('api_piecharts_addresses', 1440, function() {
            $results = \App\Address::where('type', '!=', '')
                ->selectRaw('COUNT(*) as count, type as category')
                ->groupBy('category')
                ->orderBy('count')
                ->get();

            return \App\Http\Resources\CategoryResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAssets(Request $request)
    {
        return \Cache::remember('api_piecharts_assets', 1440, function() {
            $results = \App\Asset::where('type', '!=', '')
                ->selectRaw('COUNT(*) as count, type as category')
                ->groupBy('category')
                ->orderBy('count')
                ->get();

            return \App\Http\Resources\CategoryResource::collection($results);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showBlocks(Request $request)
    {
        return \Cache::remember('api_piecharts_blocks', 1440, function() {
            $block_count_total = \App\Block::count();
            $block_count_counterparty = \App\Block::has('transactions')->count();

            return [
                'data' => [
                    ['Has Counterparty', $block_count_counterparty],
                    ['Does Not Contain', $block_count_total - $block_count_counterparty]
                ]
            ];
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMessages(Request $request)
    {
        return \Cache::remember('api_piecharts_messages', 1440, function() {
            $results = \App\Message::where('category', '!=', '')
                ->selectRaw('COUNT(*) as count, category')
                ->groupBy('category')
                ->orderBy('count')
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
        return \Cache::remember('api_piecharts_transactions', 1440, function() {
            $results = \App\Transaction::whereNotNull('processed_at')
                ->where('type', '!=', '')
                ->selectRaw('COUNT(*) as count, type as category')
                ->groupBy('category')
                ->orderBy('count')
                ->get();

            return \App\Http\Resources\CategoryResource::collection($results);
        });
    }
}
