<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RpsExpiration extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'rps_index';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'block_index',
         'rps_index',
         'rps_hash',
         'source',
         'confirmed_at',
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
