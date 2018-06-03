<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return \Cache::remember('api_addresses_index_' . $request->input('page', 1) . '_' . $request->input('per_page', 10), 60, function () use ($request) {
            $addresses = \App\Address::orderBy('block_index', 'desc')
                ->paginate($request->input('per_page', 10));

            return \App\Http\Resources\AddressResource::collection($addresses);
        });
    }
}
