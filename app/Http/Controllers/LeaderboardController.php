<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $most_xcp = \Cache::remember('most_xcp', 10080, function () {
            return \App\Balance::where('asset', '=', 'XCP')
                ->where('current', '=', 1)
                ->orderBy('quantity', 'desc')
                ->take(10)
                ->get();
        });

        $most_balances = \Cache::remember('most_balances', 10080, function () {
            return \App\Address::withCount('currentBalances')
                ->orderBy('current_balances_count', 'desc')
                ->take(10)
                ->get();
        });

        $most_active = \Cache::remember('most_active', 10080, function () {
            return \App\Address::withCount('balances')
                ->orderBy('balances_count', 'desc')
                ->take(10)
                ->get();
        });

        $most_assets = \Cache::remember('most_assets', 10080, function () {
            return \App\Address::withCount('issuedAssets')
                ->orderBy('issued_assets_count', 'desc')
                ->take(10)
                ->get();
        });

        $most_sends = \Cache::remember('most_sends', 10080, function () {
            return \App\Address::withCount('sends')
                ->orderBy('sends_count', 'desc')
                ->take(10)
                ->get();
        });

        $most_orders = \Cache::remember('most_orders', 10080, function () {
            return \App\Address::withCount('orders')
                ->orderBy('orders_count', 'desc')
                ->take(10)
                ->get();
        });

        $most_broadcasts = \Cache::remember('most_broadcasts', 10080, function () {
            return \App\Address::withCount('broadcasts')
                ->orderBy('broadcasts_count', 'desc')
                ->take(10)
                ->get();
        });

        $most_dividends = \Cache::remember('most_dividends', 10080, function () {
            return \App\Address::withCount('dividends')
                ->orderBy('dividends_count', 'desc')
                ->take(10)
                ->get();
        });

        $most_bets = \Cache::remember('most_bets', 10080, function () {
            return \App\Address::withCount('bets')
                ->orderBy('bets_count', 'desc')
                ->take(10)
                ->get();
        });

        $most_asset_holders = \Cache::remember('most_asset_holders', 10080, function () {
            return \App\Asset::withCount('currentBalances')
                ->orderBy('current_balances_count', 'desc')
                ->take(10)
                ->get();
        });

        $most_active_assets = \Cache::remember('most_active_assets', 10080, function () {
            return \App\Asset::withCount('balances')
                ->orderBy('balances_count', 'desc')
                ->take(10)
                ->get();
        });

        $most_asset_sends = \Cache::remember('most_asset_sends', 10080, function () {
            return \App\Asset::withCount('sends')
                ->orderBy('sends_count', 'desc')
                ->take(10)
                ->get();
        });

        $most_asset_trades = \Cache::remember('most_asset_trades', 10080, function () {
            return \App\Credit::where('action', '=', 'order match')
                ->selectRaw('COUNT(*) as count, asset')
                ->groupBy('asset')
                ->orderBy('count', 'desc')
                ->take(10)
                ->get();
        });

        $most_asset_dividends = \Cache::remember('most_asset_dividends', 10080, function () {
            return \App\Asset::withCount('dividends')
                ->orderBy('dividends_count', 'desc')
                ->take(10)
                ->get();
        });

        $most_btc_paid = \Cache::remember('most_btc_paid', 10080, function () {
            return \App\Transaction::selectRaw('SUM(fee) as fees, source as address')
                ->groupBy('address')
                ->orderBy('fees', 'desc')
                ->take(10)
                ->get();
        });

        $most_xcp_paid = \Cache::remember('most_xcp_paid', 10080, function () {
            return \App\Debit::where('action', 'like', '% fee')
                ->selectRaw('SUM(quantity) as fees, address')
                ->groupBy('address')
                ->orderBy('fees', 'desc')
                ->take(10)
                ->get();
        });
        return view('leaderboard.index', compact('most_xcp', 'most_balances', 'most_active', 'most_assets', 'most_sends', 'most_orders', 'most_broadcasts', 'most_dividends', 'most_bets', 'most_asset_holders', 'most_active_assets', 'most_asset_sends', 'most_asset_trades', 'most_asset_dividends', 'most_btc_paid', 'most_xcp_paid'));
    }
}
