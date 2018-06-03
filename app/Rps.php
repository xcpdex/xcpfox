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
        'block_index', 'expiration', 'expire_index', 'move_random_hash', 'possible_moves', 'source', 'status', 'tx_hash', 'tx_index', 'wager', 'wager_usd', 'quality_score', 'confirmed_at',
    ];

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = [
        'confirmed_at',
    ];

    /**
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = [
        'wager_normalized'
    ];

    /**
     * Wager Normalized
     *
     * @return string
     */
    public function getWagerNormalizedAttribute()
    {
        return fromSatoshi($this->wager);
    }
}
