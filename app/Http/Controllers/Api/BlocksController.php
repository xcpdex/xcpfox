<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlocksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'sometimes|integer|max:100',
        ]);

        return \Cache::tags(['block_flush'])->rememberForever('api_blocks_index_' . $request->input('page', 1) . '_' . $request->input('per_page', 10), function () use ($request) {
            $blocks = \App\Block::whereNotNull('processed_at')
                ->withCount('addresses', 'messages', 'transactions')
                ->orderBy('block_index', 'desc')
                ->paginate($request->input('per_page', 10));

            return \App\Http\Resources\BlockResource::collection($blocks);
        });
    }
}
