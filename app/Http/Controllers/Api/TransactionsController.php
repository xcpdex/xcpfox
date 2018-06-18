<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionsController extends Controller
{
    /**
     * Transaction Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type=null)
    {
        $request->validate([
            'per_page' => 'sometimes|integer|in:10,25,50,100',
        ]);

        $key = getKeyFromRequest('api_transactions_index_' . $type, $request);

        return \Cache::tags(['block_flush'])->rememberForever($key, function () use ($request, $type) {
            if($type)
            {
                $transactions = \App\Transaction::whereNotNull('processed_at')
                    ->where('type', '=', $type)
                    ->orderBy('tx_index', 'desc')
                    ->paginate($request->input('per_page', 10));
            }
            else
            {
                $transactions = \App\Transaction::whereNotNull('processed_at')
                    ->orderBy('tx_index', 'desc')
                    ->paginate($request->input('per_page', 10));
            }

            return \App\Http\Resources\TransactionResource::collection($transactions);
        });
    }
}
