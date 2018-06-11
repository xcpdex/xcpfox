<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateBalances implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $block;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Block $block)
    {
        $this->block = $block;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $credits = $this->getCredits();
        $debits = $this->getDebits();
        $changes = $this->getChanges($credits, $debits);
        $unique_changes = $this->getUniqueChanges($changes);

        foreach($unique_changes as $changed)
        {
            \App\Jobs\UpdateBalance::dispatch($changed['address'], $changed['asset'])->onQueue('high');
        }
    }

    /**
     * Get Unique Changes
     */
    private function getUniqueChanges($changes)
    {
        return $changes->unique(function ($change) {
            return $change['address'].$change['asset'];
        });
    }

    /**
     * Get Changes
     */
    private function getChanges($credits, $debits)
    {
        return collect(array_merge($credits, $debits));
    }

    /**
     * Get Credits for Block
     */
    private function getCredits()
    {
        return \App\Credit::where('block_index', '=', $this->block->block_index)
            ->select('address', 'asset')
            ->groupBy('address', 'asset')
            ->get()
            ->toArray();
    }

    /**
     * Get Debits for Block
     */
    private function getDebits()
    {
        return \App\Debit::where('block_index', '=', $this->block->block_index)
            ->select('address', 'asset')
            ->groupBy('address', 'asset')
            ->get()
            ->toArray();
    }
}