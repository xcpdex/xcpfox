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
         'tx_index', 'block_index', 'tx_hash', 'type', 'source', 'destination', 'quantity', 'quantity_usd', 'fee', 'fee_usd', 'size', 'vsize', 'inputs', 'outputs', 'raw', 'timestamp', 'confirmed_at', 'processed_at',
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
}
