<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issuance extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'tx_index';

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => \App\Events\IssuanceWasCreated::class,
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
        'issuer',
        'asset',
        'asset_longname',
        'description',
        'quantity',
        'quantity_normalized',
        'callable',
        'call_date',
        'call_price',
        'divisible',
        'locked',
        'transfer',
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
        'display_name',
        'fee_paid_normalized',
    ];

    /**
     * Display Name
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return $this->asset_longname ? $this->asset_longname : $this->asset;
    }

    /**
     * Fee Paid
     *
     * @return string
     */
    public function getFeePaidNormalizedAttribute()
    {
        return fromSatoshi($this->fee_paid);
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
}