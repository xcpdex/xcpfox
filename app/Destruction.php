<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destruction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asset', 'block_index', 'quantity', 'source', 'status', 'tag', 'tx_hash', 'tx_index', 'confirmed_at',
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
