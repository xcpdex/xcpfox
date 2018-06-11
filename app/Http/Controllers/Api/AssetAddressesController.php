<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetAddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chart(Request $request, $asset_name)
    {
        $request->validate([
            'group_by' => 'sometimes|in:date,month,year'
        ]);

        $group_by = $request->input('group_by', 'date');

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
        }

        return \Cache::remember('api_chart_asset_addresses_' . $asset_name . '_' . $group_by, 1440, function() use($asset, $group_by) {
            switch($group_by)
            {
                case 'date':
                    $results = $asset->balances()
                        ->selectRaw('DATE(confirmed_at) as date, COUNT(DISTINCT address) as count')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;
                case 'month':
                    $results = $asset->balances()
                        ->selectRaw('YEAR(confirmed_at) as year, MONTH(confirmed_at) as month, COUNT(DISTINCT address) as count')
                        ->groupBy('month', 'year')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get();
                    break;
                case 'year':
                    $results = $asset->balances()
                        ->selectRaw('YEAR(confirmed_at) as year, COUNT(DISTINCT address) as count')
                        ->groupBy('year')
                        ->orderBy('year')
                        ->get();
                    break;
            }

            return \App\Http\Resources\CountResource::collection($results);
        });
    }
}