<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dividend extends Model
{
    protected $primaryKey = 'tx_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asset', 'block_index', 'dividend_asset', 'fee_paid', 'quantity_per_unit', 'source', 'status', 'tx_hash', 'tx_index', 'confirmed_at',
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
