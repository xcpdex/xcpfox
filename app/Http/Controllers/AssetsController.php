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
    public function show(Request $request, $asset_name)
    {
        try
        {
            $asset = \Cache::tags([$asset_name])->rememberForever('assets_show_' . $asset_name, function () use ($asset_name) {
                return \App\Asset::where('asset_name', '=', $asset_name)
                    ->withCount('currentBalances', 'sends')
                    ->orWhere('asset_longname', '=', $asset_name)
                    ->withCount('currentBalances', 'sends')
                    ->firstOrFail();
            });
        }
        catch(\Exception $e)
        {
            //
        }

        return view('assets.show', compact('asset'));
    }
}
