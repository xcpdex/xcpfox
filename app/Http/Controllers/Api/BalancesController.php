<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BalancesController extends Controller
{
    /**
     * Show Balances
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $address)
    {
        $address = \App\Address::findOrFail($address);

        $key = $address->address . '_balances';

        return \Cache::tags([$address->address . '_balances'])->rememberForever($key, function () use ($address) {
            $results = $address->currentBalances()
                ->where('asset', '!=', 'BTC')
                ->with('addressModel', 'assetModel')
                ->orderBy('asset', 'asc')
                ->get();

            return \App\Http\Resources\BalanceResource::collection($results);
        });
    }
}
