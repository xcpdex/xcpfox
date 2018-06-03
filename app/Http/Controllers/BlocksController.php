<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlocksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('blocks.index', compact('request'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $block)
    {
        try
        {
            $block = \App\Block::withCount('messages')->whereBlockHash($block)->firstOrFail();
        }
        catch(\Exception $e)
        {
            $block = \App\Block::withCount('messages')->findOrFail($block);
        }

        $fee = \Cache::remember('block_' . $block->block_index . '_fee', 1440, function () use ($block) {
            return $block->transactions()->sum('fee');
        });

        $fee_usd = \Cache::remember('block_' . $block->block_index . '_fee_usd', 1440, function () use ($block) {
            return $block->transactions()->sum('fee_usd');
        });

        $size = \Cache::remember('block_' . $block->block_index . '_size', 1440, function () use ($block) {
            return $block->transactions()->sum('vsize');
        });

        $weight = \Cache::remember('block_' . $block->block_index . '_weight', 1440, function () use ($block) {
            return $block->transactions()->sum('vsize') * 4;
        });

        $transactions = \Cache::remember('block_' . $block->block_index . '_transactions', 1440, function () use ($block) {
            return $block->transactions()->orderBy('tx_index', 'desc')->get();
        });

        $messages = \Cache::remember('block_' . $block->block_index . '_messages', 1440, function () use ($block) {
            return $block->messages()->doesntHave('transaction')->selectRaw('COUNT(*) as count, category, command')->groupBy('command', 'category')->orderBy('category', 'desc')->get();
        });

        $prev_block = \Cache::remember('block_' . $block->block_index . '_prev_block', 1440, function () use ($block) {
            return \App\Block::has('messages')->where('block_index', '<', $block->block_index)->orderBy('block_index', 'desc')->first();
        });

        $next_block = \Cache::remember('block_' . $block->block_index . '_next_block', 1440, function () use ($block) {
            return \App\Block::has('messages')->where('block_index', '>', $block->block_index)->orderBy('block_index', 'asc')->first();
        });

        return view('blocks.show', compact('block', 'fee', 'fee_usd', 'size', 'weight', 'transactions', 'messages', 'prev_block', 'next_block'));
    }
}
