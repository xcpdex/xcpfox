<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'tx_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block_index', 'expiration', 'expire_index', 'fee_provided', 'fee_provided_remaining', 'fee_required', 'fee_required_remaining', 'get_asset', 'get_quantity', 'get_quantity_usd', 'get_remaining', 'get_remaining_usd', 'give_asset', 'give_quantity', 'give_quantity_usd', 'give_remaining', 'give_remaining_usd', 'source', 'status', 'tx_hash', 'tx_index', 'confirmed_at',
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
