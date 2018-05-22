<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderExpiration extends Model
{
    protected $primaryKey = 'order_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'order_index', 'block_index', 'order_hash', 'source', 'confirmed_at',
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
