<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetsController extends Controller
{
    /**
     * Asset Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type=null)
    {
        $request->validate([
            'per_page' => 'sometimes|integer|in:10,25,50,100',
        ]);

        $key = getKeyFromRequest('api_assets_index_' . $type, $request);

        return \Cache::tags(['issuance_flush'])->rememberForever($key, function () use ($request, $type) {
            if($type)
            {
                $assets = \App\Asset::where('type', '=', $type)
                    ->with('ownerAddress')
                    ->withCount('currentBalances')
                    ->orderBy('tx_index', 'desc')
                    ->paginate($request->input('per_page', 10));
            }
            else
            {
                $assets = \App\Asset::with('ownerAddress')
                    ->withCount('currentBalances')
                    ->orderBy('tx_index', 'desc')
                    ->paginate($request->input('per_page', 10));
            }

            return \App\Http\Resources\AssetResource::collection($assets);
        });
    }
}
