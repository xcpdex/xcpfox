<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
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
        'expiration',
        'give_asset',
        'give_quantity',
        'give_quantity_usd',
        'give_remaining',
        'give_remaining_usd',
        'get_asset',
        'get_quantity',
        'get_quantity_usd',
        'get_remaining',
        'get_remaining_usd',
        'fee_provided',
        'fee_provided_remaining',
        'fee_required',
        'fee_required_remaining',
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
        'get_quantity_normalized',
        'get_quantity_usd_normalized',
        'get_remaining_normalized',
        'get_remaining_usd_normalized',
        'give_quantity_normalized',
        'give_quantity_usd_normalized',
        'give_remaining_normalized',
        'give_remaining_usd_normalized',
    ];

    /**
     * Get Quantity Normalized
     *
     * @return string
     */
    public function getGetQuantityNormalizedAttribute()
    {
        return $this->getAssetModel->divisible ? fromSatoshi($this->get_quantity) : sprintf("%.8f", $this->get_quantity);
    }

    /**
     * Get Quantity USD Normalized
     *
     * @return string
     */
    public function getGetQuantityUsdNormalizedAttribute()
    {
        return $this->getAssetModel->divisible ? fromSatoshi($this->get_quantity_usd) : $this->get_quantity_usd;
    }

    /**
     * Get Remaining Normalized
     *
     * @return string
     */
    public function getGetRemainingNormalizedAttribute()
    {
        return $this->getAssetModel->divisible ? fromSatoshi($this->get_remaining) : sprintf("%.8f", $this->get_remaining);
    }

    /**
     * Get Remaining USD Normalized
     *
     * @return string
     */
    public function getGetRemainingUsdNormalizedAttribute()
    {
        return $this->getAssetModel->divisible ? fromSatoshi($this->get_remaining_usd) : $this->get_remaining_usd;
    }

    /**
     * Give Quantity Normalized
     *
     * @return string
     */
    public function getGiveQuantityNormalizedAttribute()
    {
        return $this->giveAssetModel->divisible ? fromSatoshi($this->give_quantity) : sprintf("%.8f", $this->give_quantity);
    }

    /**
     * Give Quantity USD Normalized
     *
     * @return string
     */
    public function getGiveQuantityUsdNormalizedAttribute()
    {
        return $this->giveAssetModel->divisible ? fromSatoshi($this->give_quantity_usd) : $this->give_quantity_usd;
    }

    /**
     * Give Remaining Normalized
     *
     * @return string
     */
    public function getGiveRemainingNormalizedAttribute()
    {
        return $this->giveAssetModel->divisible ? fromSatoshi($this->give_remaining) : sprintf("%.8f", $this->give_remaining);
    }

    /**
     * Give Remaining USD Normalized
     *
     * @return string
     */
    public function getGiveRemainingUsdNormalizedAttribute()
    {
        return $this->giveAssetModel->divisible ? fromSatoshi($this->give_remaining_usd) : $this->give_remaining_usd;
    }

    /**
     * Get Asset
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getAssetModel()
    {
        return $this->belongsTo(Asset::class, 'get_asset', 'asset_name');
    }

    /**
     * Give Asset
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function giveAssetModel()
    {
        return $this->belongsTo(Asset::class, 'give_asset', 'asset_name');
    }
}
