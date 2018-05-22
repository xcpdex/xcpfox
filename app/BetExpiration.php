<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetExpiration extends Model
{
    protected $primaryKey = 'bet_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'bet_index', 'block_index', 'bet_hash', 'source', 'confirmed_at',
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
