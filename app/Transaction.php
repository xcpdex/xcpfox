<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'tx_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'tx_index', 'block_index', 'message_index', 'tx_hash', 'type', 'source', 'destination', 'quantity', 'quantity_usd', 'fee', 'fee_usd', 'size', 'vsize', 'inputs', 'outputs', 'raw', 'valid', 'quality_score', 'timestamp', 'confirmed_at', 'processed_at',
    ];

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = [
        'confirmed_at', 'processed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'raw' => 'array',
    ];

    /**
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = [
        'url', 'block_url',
        'fee_normalized', 'fee_usd_normalized',
        'quantity_normalized', 'quantity_usd_normalized',
    ];

    /**
     * URL
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url(route('transactions.show', ['tx_hash' => $this->tx_hash]));
    }

    /**
     * Block URL
     *
     * @return string
     */
    public function getBlockUrlAttribute()
    {
        return url(route('blocks.show', ['block_hash' => $this->block_index]));
    }

    /**
     * Get Fee Normalized
     *
     * @return string
     */
    public function getFeeNormalizedAttribute()
    {
        return fromSatoshi($this->fee);
    }

    /**
     * Get Fee USD Normalized
     *
     * @return string
     */
    public function getFeeUsdNormalizedAttribute()
    {
        return fromSatoshi($this->fee_usd);
    }

    /**
     * Get Quantity Normalized
     *
     * @return string
     */
    public function getQuantityNormalizedAttribute()
    {
        return fromSatoshi($this->quantity);
    }

    /**
     * Get Quantity USD Normalized
     *
     * @return string
     */
    public function getQuantityUsdNormalizedAttribute()
    {
        return fromSatoshi($this->quantity_usd);
    }

    /**
     * Related Model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function relatedModel()
    {
        return $this->hasOne(getModelNameFromType($this->type), 'tx_hash', 'tx_hash');
    }

    /**
     * Block
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function block()
    {
        return $this->belongsTo(Block::class, 'block_index', 'block_index');
    }

    /**
     * Message
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message()
    {
        return $this->belongsTo(Message::class, 'message_index', 'message_index');
    }

    /**
     * Processed Txs
     */
    public function scopeProcessed($query)
    {
        return $query->whereNotNull('processed_at');
    }

    /**
     * First or Create Transaction
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Transaction
     */
    public static function firstOrCreateTransaction($message, $bindings)
    {
        return static::firstOrCreate([
            'tx_index' => $bindings['tx_index'],
        ],[
            'message_index' => $message['message_index'],
            'type' => $message['category'],
            'source' => $bindings['source'],
            'tx_hash' => $bindings['tx_hash'],
            'block_index' => $bindings['block_index'],
            'destination' => isset($bindings['destination']) ? $bindings['destination'] : null,
            'valid' => strpos($bindings['status'], 'invalid') === false ? 1 : 0,
            'timestamp' => $message['timestamp'],
            'confirmed_at' => $bindings['confirmed_at'],
        ]);
    }
}
