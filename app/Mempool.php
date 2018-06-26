<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mempool extends Model
{
    public $incrementing = false;
    protected $table = 'mempool';
    protected $primaryKey = 'tx_hash';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'tx_hash',
         'category',
         'command',
         'bindings',
         'timestamp',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'bindings' => 'array',
    ];

    /**
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = [
        'url',
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
     * Transaction
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'tx_hash', 'tx_hash');
    }
}