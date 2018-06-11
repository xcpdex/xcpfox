<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('assets.index', compact('request'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function typeIndex(Request $request, $type)
    {
        return view('assets.type-index', compact('request', 'type'));
    }

    /**
     * Display a listing of the resource.
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

        $related_assets = \Cache::remember('assests_show_' . $asset->asset_name . '_related_assets', 1440, function () use ($asset) {
            $holders = $asset->currentBalances()
                ->distinct('address')
                ->select('address')
                ->get();

            $addresses = [];

            foreach($holders as $holder)
            {
                $addresses[] = $holder->address;
            }

            return \App\Balance::current()
                ->where('asset', '!=', $asset->asset_name)
                ->whereIn('address', $addresses)
                ->selectRaw('COUNT(*) as count, asset')
                ->groupBy('asset')
                ->orderBy('count', 'desc')
                ->take(10)
                ->get();
        });

        $top_holders = \Cache::remember('assets_show_' . $asset->asset_name . '_top_holders', 1440, function () use ($asset) {
            return $asset->currentBalances()
                ->orderBy('quantity', 'desc')
                ->take(10)
                ->get();
        });

        return view('assets.show', compact('asset', 'related_assets', 'top_holders'));
    }
}
