<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RpsExpiration extends Model
{
    protected $primaryKey = 'rps_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'rps_index', 'block_index', 'rps_hash', 'source', 'confirmed_at',
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
