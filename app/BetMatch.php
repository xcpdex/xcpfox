<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetMatch extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'backward_quantity', 'block_index', 'deadline', 'fee_fraction_int', 'feed_address', 'forward_quantity', 'id', 'initial_value', 'leverage', 'match_expire_index', 'status', 'target_value', 'tx0_address', 'tx0_bet_type', 'tx0_block_index', 'tx0_expiration', 'tx0_hash', 'tx0_index', 'tx1_address', 'tx1_bet_type', 'tx1_block_index', 'tx1_expiration', 'tx1_hash', 'tx1_index', 'confirmed_at',
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
