<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetsController extends Controller
{
    /**
     * Asset Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type=null)
    {
        return view('assets.index', compact('request', 'type'));
    }

    /**
     * Show an Asset
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $asset_name)
    {
        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_show_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_longname', '=', $asset_name)
                    ->withCount('currentBalances', 'sends')
                    ->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_show_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)
                    ->withCount('currentBalances', 'sends')
                    ->firstOrFail();
            });

            return redirect($asset->url);
        }

        $burned_supply = \Cache::remember('assests_show_' . $asset->asset_name . '_burned_supply', 1440, function () use ($asset) {
            $quantity = $asset->currentBalances()
                ->whereHas('addressModel', function($address) {
                    $address->where('burn', '=', 1);
                })->sum('quantity');

            if($asset->asset_name === 'XCP')
            {
                $quantity = $quantity + \App\Debit::where('action', 'like', '% fee')->sum('quantity');
            }

            return $asset->divisible ? fromSatoshi($quantity) : sprintf("%.8f", $quantity);
        });

        $active_addresses_count = \Cache::remember('assests_show_' . $asset->asset_name . '_arctive_addresses', 1440, function () use ($asset) {
            return \App\Balance::where('asset', '=', $asset->asset_name)
                ->where('confirmed_at', '>', \Carbon\Carbon::now()->subDays(30))
                ->selectRaw('COUNT(DISTINCT address) as count')
                ->first()
                ->count;
        });

        $sends_total = \Cache::remember('assests_show_' . $asset->asset_name . '_sends_total', 1440, function () use ($asset) {
            $quantity = $asset->sends()->sum('quantity');

            return $asset->divisible ? fromSatoshi($quantity) : sprintf("%.8f", $quantity);
        });

        $trades_count = \Cache::remember('assests_show_' . $asset->asset_name . '_trades_count', 1440, function () use ($asset) {
            return $asset->credits()->where('action', '=', 'order match')->count();
        });

        $trades_total = \Cache::remember('assests_show_' . $asset->asset_name . '_trades_total', 1440, function () use ($asset) {
            $quantity = $asset->credits()->where('action', '=', 'order match')->sum('quantity');

            return $asset->divisible ? fromSatoshi($quantity) : sprintf("%.8f", $quantity);
        });

        return view('assets.show', compact('asset', 'burned_supply', 'active_addresses_count', 'sends_total', 'trades_count', 'trades_total'));
    }
}
