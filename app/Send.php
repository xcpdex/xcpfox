<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Send extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'tx_index';

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => \App\Events\SendWasCreated::class,
    ];

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
        'destination',
        'asset',
        'quantity',
        'quantity_usd',
        'memo',
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

    /**
     * Transaction
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'tx_hash', 'tx_hash');
    }
}
