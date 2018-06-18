<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlocksController extends Controller
{
    /**
     * Block Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => 'sometimes|integer|in:10,25,50,100',
        ]);

        $key = getKeyFromRequest('api_blocks_index', $request);

        return \Cache::tags(['block_flush'])->rememberForever($key, function () use ($request) {
            $blocks = \App\Block::whereNotNull('processed_at')
                ->withCount('addresses', 'messages', 'transactions')
                ->orderBy('block_index', 'desc')
                ->paginate($request->input('per_page', 10));

            return \App\Http\Resources\BlockResource::collection($blocks);
        });
    }
}
