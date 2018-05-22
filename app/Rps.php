<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rps extends Model
{
    protected $primaryKey = 'tx_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block_index', 'expiration', 'expire_index', 'move_random_hash', 'possible_moves', 'source', 'status', 'tx_hash', 'tx_index', 'wager', 'confirmed_at',
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
