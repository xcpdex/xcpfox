<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dividend extends Model
{
    protected $primaryKey = 'tx_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asset', 'block_index', 'dividend_asset', 'fee_paid', 'fee_paid_usd', 'quantity_per_unit', 'quantity_per_unit_usd', 'source', 'status', 'tx_hash', 'tx_index', 'quality_score', 'confirmed_at',
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
        'quantity_per_unit_normalized', 'quantity_per_unit_usd_normalized',
        'fee_paid_normalized', 'fee_paid_usd_normalized',
    ];

    /**
     * Quantity Per Unit Normalized
     *
     * @return string
     */
    public function getQuantityPerUnitNormalizedAttribute()
    {
        return $this->dividendAssetModel->divisible ? fromSatoshi($this->quantity_per_unit) : $this->quantity_per_unit;
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
