<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'sometimes|integer|in:10,25,50,100',
        ]);

        return \Cache::tags(['block_flush'])->rememberForever('api_transactions_index_' . $request->input('page', 1) . '_' . $request->input('per_page', 10), function () use ($request) {
            $transactions = \App\Transaction::whereNotNull('processed_at')
                ->orderBy('tx_index', 'desc')
                ->paginate($request->input('per_page', 10));

            return \App\Http\Resources\TransactionResource::collection($transactions);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $tx_type)
    {
        $request->validate([
            'per_page' => 'sometimes|integer|in:10,25,50,100',
        ]);

        if(in_array($tx_type, ['bets', 'broadcasts', 'btcpays', 'burns', 'cancels', 'dividends', 'issuances', 'orders', 'rps', 'rpsresolves', 'sends']))
        {
            return \Cache::tags(['block_flush'])->rememberForever('api_transactions_show_' . $tx_type . '_' . $request->input('page', 1) . '_' . $request->input('per_page', 10), function () use ($request, $tx_type) {
                $transactions = \App\Transaction::whereNotNull('processed_at')
                    ->where('type', '=', $tx_type)
                    ->orderBy('tx_index', 'desc')
                    ->paginate($request->input('per_page', 10));

                return \App\Http\Resources\TransactionResource::collection($transactions);
            });
        }
    }
}
