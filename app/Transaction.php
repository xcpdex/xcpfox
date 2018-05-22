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
         'tx_index', 'block_index', 'tx_hash', 'type', 'source', 'destination', 'quantity', 'quantity_usd', 'fee', 'fee_usd', 'size', 'vsize', 'inputs', 'outputs', 'raw', 'valid', 'timestamp', 'confirmed_at', 'processed_at',
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
     * Block
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function block()
    {
        return $this->belongsTo(Block::class, 'block_index', 'block_index');
    }

    /**
     * Update or Create Transaction
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Transaction
     */
    public static function updateOrCreateTransaction($message, $bindings)
    {
        try
        {
            return static::updateOrCreate([
                'tx_index' => $bindings['tx_index'],
            ],[
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
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Transaction: ' . $message['message_index'] . ' ' . serialize($e->getMessage()));
        }
    }
}
