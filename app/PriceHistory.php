<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticker', 'price', 'timestamp', 'confirmed_at'
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
