<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dividend extends Model
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
        'status',
        'source',
        'asset',
        'dividend_asset',
        'quantity_per_unit',
        'quantity_per_unit_usd',
        'fee_paid',
        'fee_paid_usd',
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
        'fee_paid_normalized',
        'fee_paid_usd_normalized',
        'quantity_per_unit_normalized',
        'quantity_per_unit_usd_normalized',
    ];

    /**
     * Fee Paid Normalized
     *
     * @return string
     */
    public function getFeePaidNormalizedAttribute()
    {
        return fromSatoshi($this->fee_paid);
    }

    /**
     * Fee Paid USD Normalized
     *
     * @return string
     */
    public function getFeePaidUsdNormalizedAttribute()
    {
        return fromSatoshi($this->fee_paid_usd);
    }

    /**
     * Quantity Per Unit Normalized
     *
     * @return string
     */
    public function getQuantityPerUnitNormalizedAttribute()
    {
        return $this->dividendAssetModel->divisible ? fromSatoshi($this->quantity_per_unit) : sprintf("%.8f",$this->quantity_per_unit);
    }

    /**
     * Quantity Per Unit USD Normalized
     *
     * @return string
     */
    public function getQuantityPerUnitUsdNormalizedAttribute()
    {
        return $this->dividendAssetModel->divisible ? fromSatoshi($this->quantity_per_unit_usd) : $this->quantity_per_unit_usd;
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

    /**
     * Dividend Asset
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dividendAssetModel()
    {
        return $this->belongsTo(Asset::class, 'dividend_asset', 'asset_name');
    }
}
