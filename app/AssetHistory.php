<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asset', 'type', 'value', 'quality_score', 'timestamp', 'confirmed_at'
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
