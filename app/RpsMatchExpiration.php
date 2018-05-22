<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RpsMatchExpiration extends Model
{
    protected $primaryKey = 'rps_match_id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'rps_match_id', 'block_index', 'tx0_address', 'tx1_address', 'confirmed_at',
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
