<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rps extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'tx_index';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block_index',
        'expire_index',
        'tx_index',
        'tx_hash',
        'status',
        'source',
        'wager',
        'wager_usd',
        'possible_moves',
        'move_random_hash',
        'expiration',
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
