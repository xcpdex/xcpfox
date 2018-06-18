<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlocksController extends Controller
{
    /**
     * Block Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('blocks.index', compact('request'));
    }

    /**
     * Show a Block
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
            $block = \App\Block::findOrFail($block);

            return redirect($block->url);
        }

        // Counterparty
        $fee = $this->getData($block, 'fee');
        $fee_usd = $this->getData($block, 'fee_usd');
        $size = $this->getData($block, 'vsize');
        $weight = $this->getData($block, 'vsize') * 4;
        $transactions = $this->getData($block, 'transactions');
        $messages = $this->getData($block, 'messages');
        $prev_block = $this->getData($block, 'prev_block');
        $next_block = $this->getData($block, 'next_block');

        return view('blocks.show', compact('block', 'fee', 'fee_usd', 'size', 'weight', 'transactions', 'messages', 'prev_block', 'next_block'));
    }

    /**
     * Get Data Tool
     *
     * @return mixed
     */
    private function getData($block, $key, $expiration=1440)
    {
        return \Cache::remember($this->getCacheKey($key, $block), $expiration, function () use ($block, $key) {
            switch($key)
            {
                case 'fee':
                    return $block->transactions()->sum('fee');
                case 'fee_usd':
                    return $block->transactions()->sum('fee_usd');
                case 'vsize':
                    return $block->transactions()->sum('vsize');
                case 'transactions':
                    return $block->transactions()->orderBy('tx_index', 'desc')->get();
                case 'messages':
                    return $block->messages()->doesntHave('transaction')->selectRaw('COUNT(message_index) as count, category, command')->groupBy('command', 'category')->orderBy('category', 'desc')->get();
                case 'prev_block':
                    return \App\Block::has('messages')->where('block_index', '<', $block->block_index)->orderBy('block_index', 'desc')->first();
                case 'next_block':
                    return \App\Block::has('messages')->where('block_index', '>', $block->block_index)->orderBy('block_index', 'asc')->first();
            }
        });
    }

    /**
     * Standardize Cache Keys
     *
     * @return str
     */
    private function getCacheKey($key, $block)
    {
        return 'block_' . $block->block_index . '_' . $key; // block_123456_keyword
    }
}
