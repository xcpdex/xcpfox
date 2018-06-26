<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetMatch extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block_index',
        'match_expire_index',
        'tx0_block_index',
        'tx0_index',
        'tx0_hash',
        'tx0_bet_type',
        'tx0_address',
        'tx0_expiration',
        'tx1_block_index',
        'tx1_index',
        'tx1_hash',
        'tx1_bet_type',
        'tx1_address',
        'tx1_expiration',
        'id',
        'status',
        'feed_address',
        'target_value',
        'initial_value',
        'backward_quantity',
        'backward_quantity_usd',
        'forward_quantity',
        'forward_quantity_usd',
        'leverage',
        'deadline',
        'fee_fraction_int',
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
