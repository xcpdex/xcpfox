<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetMatchResolution extends Model
{
    protected $primaryKey = 'bet_match_id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bear_credit', 'bear_credit_usd', 'bet_match_id', 'bet_match_type_id', 'block_index', 'bull_credit', 'bull_credit_usd', 'escrow_less_fee', 'escrow_less_fee_usd', 'fee', 'fee_usd', 'settled', 'winner', 'quality_score', 'confirmed_at',
    ];

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = [
        'confirmed_at',
    ];
}
