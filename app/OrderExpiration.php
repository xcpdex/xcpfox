<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderExpiration extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'order_index';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'block_index',
         'order_index',
         'order_hash',
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
