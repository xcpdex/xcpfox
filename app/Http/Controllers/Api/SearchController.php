<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'required',
        ]);

        $request->merge(['q' => str_replace('*', '', $request->q)]);

        return \Cache::remember('api_search_index_' . $request->q . '_' . $request->input('page', 1) . '_' . $request->input('per_page', 10), 60, function () use ($request) {
            if(in_array(substr($request->q, 0, 1), ['1','3']) && strlen($request->q) <= 34)
            {
                $results = \App\Address::where('address', 'like', '%' . $request->q . '%')
                    ->selectRaw('address as result, confirmed_at, type')
                    ->paginate($request->input('per_page', 10));
            }
            elseif(1 === preg_match('~[0-9]~', $request->q) && strpos($request->q, '.') === false)
            {
                $results = \App\Transaction::where('tx_hash', 'like', '%' . $request->q . '%')
                    ->selectRaw('tx_hash as result, confirmed_at, type')
                    ->paginate($request->input('per_page', 10));
            }
            else
            {
                $results = \App\Asset::where('asset_name', 'like', $request->q . '%')
                    ->orWhere('asset_longname', 'like', $request->q . '%')
                    ->selectRaw('asset_name as result, confirmed_at, asset_longname as extra, type')
                    ->paginate($request->input('per_page', 10));
            }

            return \App\Http\Resources\SearchResource::collection($results);
        });
    }
}