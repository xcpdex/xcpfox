<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $primaryKey = 'tx_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bet_type', 'block_index', 'counterwager_quantity', 'counterwager_remaining', 'deadline', 'expiration', 'expire_index', 'fee_fraction_int', 'feed_address', 'leverage', 'source', 'status', 'target_value', 'tx_hash', 'tx_index', 'wager_quantity', 'wager_remaining', 'confirmed_at',
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
