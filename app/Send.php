<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Send extends Model
{
    protected $primaryKey = 'tx_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asset', 'block_index', 'destination', 'quantity', 'quantity_usd', 'source', 'status', 'memo', 'tx_hash', 'tx_index', 'quality_score', 'confirmed_at',
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
        'quantity_normalized', 'quantity_usd_normalized',
    ];

    /**
     * Quantity Normalized
     *
     * @return string
     */
    public function getQuantityNormalizedAttribute()
    {
        return $this->assetModel->divisible ? fromSatoshi($this->quantity) : sprintf("%.8f", $this->quantity);
    }

    /**
     * Quantity USD Normalized
     *
     * @return string
     */
    public function getQuantityUsdNormalizedAttribute()
    {
        return $this->assetModel->divisible ? fromSatoshi($this->quantity_usd) : $this->quantity_usd;
    }

    /**
     * Destination Address
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destinationAddress()
    {
        return $this->belongsTo(Address::class, 'destination', 'address');
    }

    /**
     * Source Address
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sourceAddress()
    {
        return $this->belongsTo(Address::class, 'source', 'address');
    }

    /**
     * Asset
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assetModel()
    {
        return $this->belongsTo(Asset::class, 'asset', 'asset_name');
    }
}
