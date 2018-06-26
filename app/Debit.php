<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block_index',
        'event',
        'action',
        'address',
        'asset',
        'quantity',
        'quantity_usd',
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
        return $this->assetModel ? $this->assetModel->divisible ? fromSatoshi($this->quantity) : sprintf("%.8f", $this->quantity) : $this->quantity;
    }

    /**
     * Quantity USD Normalized
     *
     * @return string
     */
    public function getQuantityUsdNormalizedAttribute()
    {
        return $this->assetModel ? $this->assetModel->divisible ? fromSatoshi($this->quantity_usd) : $this->quantity_usd : $this->quantity_usd;
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
     * Transaction
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'event', 'tx_hash');
    }
}
