<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $address;
    protected $asset;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($address, $asset)
    {
        $this->address = $address;
        $this->asset = $asset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Block of Last Saved Balance
        $last_block = $this->getLastBlockIndex();

        // Blocks w/ Changes Since Then
        $blocks = $this->getBalanceChanges($last_block);
        $unique_blocks = $blocks->unique('block_index')->sortBy('block_index');

        // Crunch and Save Balances
        foreach($unique_blocks as $unique_block)
        {
            // Rename for Clarity?
            $block_index = $unique_block['block_index'];

            // Get Block as a Model
            $block = \App\Block::find($block_index);

            // Get Balance Quantity
            $quantity = $this->getQuantity($block_index);

            // Save Current Balance
            $this->createBalance($quantity, $block);

            // Expire Prior Balances
            $this->expireBalances($block_index);
        }
    }

    /**
     * Get Last Block Index
     */
    private function getLastBlockIndex()
    {
        $last_balance = $this->getLastBalance();

        return $last_balance ? $last_balance->block_index : 0;
    }

    /**
     * Get Last Balance
     */
    private function getLastBalance()
    {
        return \App\Balance::where('address', '=', $this->address)
            ->where('asset', '=', $this->asset)
            ->orderBy('block_index', 'desc')
            ->first();
    }

    /**
     * Get Balance Changes
     */
    private function getBalanceChanges($block_index)
    {
        $credit_blocks = $this->getCreditBlocks($block_index);
        $debit_blocks = $this->getDebitBlocks($block_index);

        return collect(array_merge($credit_blocks, $debit_blocks));
    }

    /**
     * Get Blocks w/ Credits
     */
    private function getCreditBlocks($block_index)
    {
        return \App\Credit::where('address', '=', $this->address)
            ->where('asset', '=', $this->asset)
            ->where('block_index', '>', $block_index)
            ->select('block_index')
            ->groupBy('block_index')
            ->get()
            ->toArray();
    }

    /**
     * Get Blocks w/ Debits
     */
    private function getDebitBlocks($block_index)
    {
        return \App\Debit::where('address', '=', $this->address)
            ->where('asset', '=', $this->asset)
            ->where('block_index', '>', $block_index)
            ->select('block_index')
            ->groupBy('block_index')
            ->get()
            ->toArray();
    }

    /**
     * Create Balance
     */
    private function createBalance($quantity, $block)
    {
        return \App\Balance::firstOrCreate([
            'address' => $this->address,
            'asset' => $this->asset,
            'block_index' => $block->block_index,
        ],[
            'current' => 1,
            'quantity' => $quantity,
            'confirmed_at' => $block->confirmed_at,
        ]);
    }

    /**
     * Get Quantity
     */
    private function getQuantity($block_index)
    {
        $credits = $this->getCredits($block_index);
        $debits = $this->getDebits($block_index);

        $quantity = $credits - $debits;

        if($quantity < 0) $quantity = 0;

        return $quantity;
    }

    /**
     * Get Credits
     */
    private function getCredits($block_index)
    {
        return \App\Credit::where('address', '=', $this->address)
                ->where('asset', '=', $this->asset)
                ->where('block_index', '<=', $block_index)
                ->sum('quantity');
    }

    /**
     * Get Debits
     */
    private function getDebits($block_index)
    {
        return \App\Debit::where('address', '=', $this->address)
                ->where('asset', '=', $this->asset)
                ->where('block_index', '<=', $block_index)
                ->sum('quantity');
    }

    /**
     * Expire Balances
     */
    private function expireBalances($block_index)
    {
        return \App\Balance::where('address', '=', $this->address)
                ->where('asset', '=', $this->asset)
                ->where('block_index', '<', $block_index)
                ->update(['current' => 0]);
    }
}