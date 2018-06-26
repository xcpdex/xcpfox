<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BlockHeightCommand extends Command
{
    protected $counterparty;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'block:height';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor Block Height';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->counterparty = new \JsonRPC\Client(env('CP_API'));
        $this->counterparty->authentication(env('CP_USER'), env('CP_PASS'));

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try
        {
            if($this->isNewBlockHeight())
            {
                $this->call('update:blocks');
                $this->call('update:blocks:next');
            }
        }
        catch(\Exception $e)
        {
            // API 404s Frequently
        }
    }

    /**
     * Check For and Handle New Block
     *
     * @return null
     */
    private function isNewBlockHeight()
    {
        $block_height = $this->getBlockHeight();

        if($block_height !== \Cache::get('block_height'))
        {
            $this->forgetBlockHeight();

            $this->setBlockHeight($block_height);

            return true;
        }

        return false;
    }

    /**
     * Get Height
     *
     * @return null
     */
    private function getBlockHeight()
    {
        $info = $this->counterparty->execute('get_running_info');

        return $info['bitcoin_block_count'];
    }

    /**
     * Set Cache
     *
     * @return null
     */
    private function setBlockHeight($block_height)
    {
        \Cache::forever('block_height', $block_height);
    }

    /**
     * Clear cache
     *
     * @return null
     */
    private function forgetBlockHeight()
    {
        \Cache::forget('block_height');
    }
}