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
            $assets = \App\Asset::orderBy('block_index', 'desc')
                ->paginate($request->input('per_page', 10));

            return \App\Http\Resources\AssetResource::collection($assets);
        });
    }
}
