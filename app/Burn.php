<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Burn extends Model
{
    protected $primaryKey = 'tx_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block_index', 'burned', 'burned_usd', 'earned', 'earned_usd', 'source', 'status', 'tx_hash', 'tx_index', 'quality_score', 'confirmed_at',
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
        'burned_normalized', 'earned_normalized',
    ];

    /**
     * Burned Normalized
     *
     * @return string
     */
    public function getBurnedNormalizedAttribute()
    {
        return fromSatoshi($this->burned);
    }

    /**
     * Earned Normalized
     *
     * @return string
     */
    public function getEarnedNormalizedAttribute()
    {
        return fromSatoshi($this->earned);
    }
}
