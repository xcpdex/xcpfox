<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateNextBlockCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:blocks:next';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Next Block';

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
        $blocks = \App\Block::whereNull('next_block_hash')->get();

        foreach($blocks as $block)
        {
            \App\Jobs\UpdateBlock::dispatch($block);
        }
    }
}