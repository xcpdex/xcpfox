<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BetMatchExpiration extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'bet_match_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'block_index',
         'bet_match_id',
         'tx0_address',
         'tx1_address',
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
