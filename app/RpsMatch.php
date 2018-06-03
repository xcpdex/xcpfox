<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RpsMatch extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block_index', 'id', 'match_expire_index', 'possible_moves', 'status', 'tx0_address', 'tx0_block_index', 'tx0_expiration', 'tx0_hash', 'tx0_index', 'tx0_move_random_hash', 'tx1_address', 'tx1_block_index', 'tx1_expiration', 'tx1_hash', 'tx1_index', 'tx1_move_random_hash', 'wager', 'wager_usd', 'quality_score', 'confirmed_at',
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
