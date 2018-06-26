<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetExpiration extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'bet_index';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'block_index',
         'bet_index',
         'bet_hash',
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
