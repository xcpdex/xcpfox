<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateIssuanceQuantityUsdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:issuances:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Issuances USD';

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
        $issuances = \App\Issuance::where('fee_paid', '>', 0)
            ->where('fee_paid_usd', '=', 0)
            ->orderBy('confirmed_at', 'desc')
            ->get();

        foreach($issuances as $issuance)
        {
            $confirmed_at = $issuance->confirmed_at->toDateString('America/New_York');

            $historical = \App\PriceHistory::where('ticker', '=', 'XCP')
                ->where('quality_score', '=', 1)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();

            if($historical)
            {
                $issuance->update([
                    'fee_paid_usd' => fromSatoshi($historical->price * $issuance->fee_paid),
                    'quality_score' => $historical->quality_score,
                ]);
            }
        }
    }
}