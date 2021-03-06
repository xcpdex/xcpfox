<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
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
        'tx_index',
        'tx_hash',
        'bet_type',
        'status',
        'source',
        'feed_address',
        'target_value',
        'wager_quantity',
        'wager_quantity_usd',
        'wager_remaining',
        'wager_remaining_usd',
        'counterwager_quantity',
        'counterwager_quantity_usd',
        'counterwager_remaining',
        'counterwager_remaining_usd',
        'leverage',
        'deadline',
        'expiration',
        'expire_index',
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

    /**
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = [
        'display_type',
        'wager_quantity_normalized',
        'wager_quantity_usd_normalized',
        'wager_remaining_normalized',
        'wager_remaining_usd_normalized',
        'counterwager_quantity_normalized',
        'counterwager_quantity_usd_normalized',
        'counterwager_remaining_normalized',
        'counterwager_remaining_usd_normalized',
    ];

    /**
     * Display Type
     *
     * @return string
     */
    public function getDisplayTypeAttribute()
    {
        return getBetType($this->type);
    }

    /**
     * Wager Quantity Normalized
     *
     * @return string
     */
    public function getWagerQuantityNormalizedAttribute()
    {
        return fromSatoshi($this->wager_quantity);
    }

    /**
     * Wager Quantity USD Normalized
     *
     * @return string
     */
    public function getWagerQuantityUsdNormalizedAttribute()
    {
        return fromSatoshi($this->wager_quantity_usd);
    }

    /**
     * Wager Remaining Normalized
     *
     * @return string
     */
    public function getWagerRemainingNormalizedAttribute()
    {
        return fromSatoshi($this->wager_remaining);
    }

    /**
     * Wager Remaining USD Normalized
     *
     * @return string
     */
    public function getWagerRemainingUsdNormalizedAttribute()
    {
        return fromSatoshi($this->wager_remaining_usd);
    }

    /**
     * Counterwager Quantity Normalized
     *
     * @return string
     */
    public function getCounterwagerQuantityNormalizedAttribute()
    {
        return fromSatoshi($this->counterwager_quantity);
    }

    /**
     * Counterwager Quantity USD Normalized
     *
     * @return string
     */
    public function getCounterwagerQuantityUsdNormalizedAttribute()
    {
        return fromSatoshi($this->counterwager_quantity_usd);
    }

    /**
     * Counterwager Remaining Normalized
     *
     * @return string
     */
    public function getCounterwagerRemainingNormalizedAttribute()
    {
        return fromSatoshi($this->counterwager_remaining);
    }

    /**
     * Counterwager Remaining USD Normalized
     *
     * @return string
     */
    public function getCounterwagerRemainingUsdNormalizedAttribute()
    {
        return fromSatoshi($this->counterwager_remaining_usd);
    }
}
