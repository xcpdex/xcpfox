<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block_index',
        'address',
        'asset',
        'quantity',
        'quantity_usd',
        'quality_score',
        'current',
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
        'quantity_normalized',
        'quantity_usd_normalized',
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
     * Address Model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function addressModel()
    {
        return $this->belongsTo(Address::class, 'address', 'address');
    }

    /**
     * Asset Model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assetModel()
    {
        return $this->belongsTo(Asset::class, 'asset', 'asset_name');
    }

    /**
     * Current Balances
     */
    public function scopeCurrent($query)
    {
        return $query->where('current', '=', 1);
    }

    /**
     * Non-Zero Balances
     */
    public function scopeNonZero($query)
    {
        return $query->where('quantity', '>', 0);
    }
}