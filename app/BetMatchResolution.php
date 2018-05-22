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
        'bear_credit', 'bet_match_id', 'bet_match_type_id', 'block_index', 'bull_credit', 'escrow_less_fee', 'fee', 'settled', 'winner', 'confirmed_at',
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
