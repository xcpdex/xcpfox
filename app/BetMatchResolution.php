<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetMatchResolution extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'bet_match_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block_index',
        'bet_match_id',
        'bet_match_type_id',
        'winner',
        'bear_credit',
        'bear_credit_usd',
        'bull_credit',
        'bull_credit_usd',
        'escrow_less_fee',
        'escrow_less_fee_usd',
        'fee',
        'fee_usd',
        'settled',
        'quality_score',
        'confirmed_at',
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
