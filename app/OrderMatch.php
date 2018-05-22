<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMatch extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'backward_asset', 'backward_quantity', 'backward_quantity_usd', 'block_index', 'fee_paid', 'forward_asset', 'forward_quantity', 'forward_quantity_usd', 'id', 'match_expire_index', 'status', 'tx0_address', 'tx0_block_index', 'tx0_expiration', 'tx0_hash', 'tx0_index', 'tx1_address', 'tx1_block_index', 'tx1_expiration', 'tx1_hash', 'tx1_index', 'confirmed_at',
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
