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
            $asset = \App\Asset::whereAssetName($asset_name)->withCount('balances', 'sends')->firstOrFail();
        }
        catch(\Exception $e)
        {
            $asset = \App\Asset::whereAssetLongname($asset_name)->withCount('balances', 'sends')->firstOrFail();
        }

        return view('assets.show', compact('asset'));
    }
}
