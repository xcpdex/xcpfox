<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMatch extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'backward_asset', 'backward_quantity', 'backward_quantity_usd', 'block_index', 'fee_paid', 'forward_asset', 'forward_quantity', 'forward_quantity_usd', 'id', 'match_expire_index', 'status', 'tx0_address', 'tx0_block_index', 'tx0_expiration', 'tx0_hash', 'tx0_index', 'tx1_address', 'tx1_block_index', 'tx1_expiration', 'tx1_hash', 'tx1_index', 'quality_score', 'confirmed_at',
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
        'backward_quantity_normalized', 'backward_quantity_usd_normalized', 'forward_quantity_normalized', 'forward_quantity_usd_normalized',
    ];

    /**
     * Get Backward Quantity Normalized
     *
     * @return string
     */
    public function getBackwardQuantityNormalizedAttribute()
    {
        return $this->backwardAssetModel->divisible ? fromSatoshi($this->backward_quantity) : sprintf("%.8f", $this->backward_quantity);
    }

    /**
     * Get Backward Quantity USD Normalized
     *
     * @return string
     */
    public function getBackwardQuantityUsdNormalizedAttribute()
    {
        return fromSatoshi($this->backward_quantity_usd);
    }

    /**
     * Get Forward Quantity Normalized
     *
     * @return string
     */
    public function getForwardQuantityNormalizedAttribute()
    {
        return $this->forwardAssetModel->divisible ? fromSatoshi($this->forward_quantity) : sprintf("%.8f", $this->forward_quantity);
    }

    /**
     * Get Forward Quantity USD Normalized
     *
     * @return string
     */
    public function getForwardQuantityUsdNormalizedAttribute()
    {
        return fromSatoshi($this->forward_quantity_usd);
    }

    /**
     * Backward Asset
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function backwardAssetModel()
    {
        return $this->belongsTo(Asset::class, 'backward_asset', 'asset_name');
    }

    /**
     * Forward Asset
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function forwardAssetModel()
    {
        return $this->belongsTo(Asset::class, 'forward_asset', 'asset_name');
    }

}