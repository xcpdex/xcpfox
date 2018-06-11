<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('transactions.index', compact('request'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function typeIndex(Request $request, $type)
    {
        return view('transactions.type-index', compact('request', 'type'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $transaction)
    {
        try
        {
            $transaction = \App\Transaction::whereTxHash($transaction)->firstOrFail();
        }
        catch(\Exception $e)
        {
            if(! is_numeric($transaction)) throw $e;

            $transaction = \App\Transaction::findOrFail($transaction);

            return redirect($transaction->url);
        }

        $tx_data = getModelNameFromType($transaction->type)::whereTxIndex($transaction->tx_index)->first();
        $tx_type = getTitleFromType($transaction->type);

        $raw_tx = null;
        if($transaction->raw !== null)
        {
            $raw_tx = $transaction->raw;
            unset($raw_tx['confirmations']);
            $raw_tx = json_encode($raw_tx, JSON_PRETTY_PRINT);
        }

        if(! $transaction->valid)
        {
            $tx_data = json_decode($transaction->message->bindings);
        }

        return view('transactions.show', compact('transaction', 'tx_type', 'tx_data', 'raw_tx'));
    }
}
