<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issuance extends Model
{
    protected $primaryKey = 'tx_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asset', 'asset_longname', 'block_index', 'call_date', 'call_price', 'callable', 'description', 'divisible', 'fee_paid', 'issuer', 'locked', 'quantity', 'source', 'status', 'transfer', 'tx_hash', 'tx_index', 'confirmed_at',
    ];

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = [
        'confirmed_at',
    ];
}
