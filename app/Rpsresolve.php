<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rpsresolve extends Model
{
    protected $primaryKey = 'tx_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block_index', 'move', 'random', 'rps_match_id', 'source', 'status', 'tx_hash', 'tx_index', 'confirmed_at',
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
