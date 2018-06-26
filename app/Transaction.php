<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
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
         'message_index',
         'tx_index',
         'tx_hash',
         'type',
         'source',
         'destination',
         'quantity',
         'quantity_usd',
         'fee',
         'fee_usd',
         'size',
         'vsize',
         'inputs',
         'outputs',
         'raw',
         'valid',
         'quality_score',
         'timestamp',
         'confirmed_at',
         'processed_at',
    ];

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = [
        'confirmed_at',
        'processed_at',
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
        'url',
        'block_url',
        'message_url',
        'source_url',
        'destination_url',
        'fee_normalized',
        'fee_usd_normalized',
        'quantity_normalized',
        'quantity_usd_normalized',
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
     * Message URL
     *
     * @return string
     */
    public function getMessageUrlAttribute()
    {
        return url(route('messages.show', ['message' => $this->message_index]));
    }

    /**
     * Source URL
     *
     * @return string
     */
    public function getSourceUrlAttribute()
    {
        return url(route('addresses.show', ['address' => $this->source]));
    }

    /**
     * Destination URL
     *
     * @return string
     */
    public function getDestinationUrlAttribute()
    {
        return $this->destination ? url(route('addresses.show', ['address' => $this->destination])) : null;
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
        $relation = getModelNameFromType($this->type);

        return $this->hasOne($relation, 'tx_hash', 'tx_hash');
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

    /**
     * Update Transaction
     *
     * @param  arr  $raw
     * @param  arr  $data
     * @return \App\Transaction
     */
    public function updateTransaction($raw, $data)
    {
        return $this->update([
            'destination' => $data[1],
            'quantity' => is_null($data[2]) ? 0 : $data[2],
            'quantity_usd' => \App\AssetHistory::convertBTCtoUSD($this, $data[2]),
            'fee' => $data[3],
            'fee_usd' => \App\AssetHistory::convertBTCtoUSD($this, $data[3]),
            'size' => $raw['size'],
            'vsize' => $raw['vsize'],
            'inputs' => count($raw['vin']),
            'outputs' => count($raw['vout']),
            'raw' => $raw,
            'quality_score' => 1,
            'confirmed_at' => $this->confirmed_at,
            'processed_at' => \Carbon\Carbon::now(),
        ]);
    }
}
