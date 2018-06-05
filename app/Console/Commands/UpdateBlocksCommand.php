<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateBlocksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:blocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Blocks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->guardAgainstSyncingDuringActiveRollbacks())
        {
            $block = \App\Block::orderBy('block_index', 'desc')->first();

            $last_block = $block ? $block->block_index : 278319;

            $next_block = $last_block + 1;

            if(\Cache::get('block_height') - $last_block < 10)
            {
                \App\Jobs\UpdateBlocks::dispatch($next_block, \Cache::get('block_height'))->onQueue('high');
            }
            else
            {
                \App\Jobs\UpdateBlocks::dispatch($next_block, $next_block + 10, true)->onQueue('high');
            }
        }
    }

    /**
     * Active Rollback Guard
     *
     * @return boolean
     */
    private function guardAgainstSyncingDuringActiveRollbacks()
    {
        return \App\Rollback::whereNull('processed_at')->doesntExist();
    }
}