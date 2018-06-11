<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return \Cache::tags(['issuance_flush'])->rememberForever('api_assets_index_' . $request->input('page', 1) . '_' . $request->input('per_page', 10), function () use ($request) {
            $assets = \App\Asset::withCount('currentBalances')
                ->orderBy('message_index', 'desc')
                ->paginate($request->input('per_page', 10));

            return \App\Http\Resources\AssetResource::collection($assets);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $asset_type)
    {
        $request->validate([
            'per_page' => 'sometimes|integer|in:10,25,50,100',
        ]);

        if(in_array($asset_type, ['asset', 'subasset', 'numeric']))
        {
            return \Cache::tags(['issuance_flush'])->rememberForever('api_assets_show_' . $asset_type . '_' . $request->input('page', 1) . '_' . $request->input('per_page', 10), function () use ($request, $asset_type) {
                $assets = \App\Asset::withCount('currentBalances')
                    ->where('type', '=', $asset_type)
                    ->orderBy('block_index', 'desc')
                    ->paginate($request->input('per_page', 10));

                return \App\Http\Resources\AssetResource::collection($assets);
            });
        }
    }
}
