<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Btcpay extends Model
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
        'order_match_id',
        'status',
        'source',
        'destination',
        'btc_amount',
        'btc_amount_usd',
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
        'btc_amount_normalized',
        'btc_amount_usd_normalized',
    ];

    /**
     * BTC Amount Normalized
     *
     * @return string
     */
    public function getBtcAmountNormalizedAttribute()
    {
        return fromSatoshi($this->btc_amount);
    }

    /**
     * BTC Amount USD Normalized
     *
     * @return string
     */
    public function getBtcAmountUsdNormalizedAttribute()
    {
        return fromSatoshi($this->btc_amount_usd);
    }
}
