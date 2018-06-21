<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateBitcoinBalancesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:bitcoin {skip : Offset} {take : Limit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Bitcoin Balances';

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
        \App\Jobs\UpdateBitcoinBalances::dispatch($this->argument('skip'), $this->argument('take'));
    }
}