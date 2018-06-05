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

    /**
     * BTC to USD on Date
     *
     * @param  arr  $model
     * @param  arr  $satoshis
     * @return \App\Transaction
     */
    public static function convertBTCtoUSD($model, $satoshis)
    {
        if(is_null($satoshis)) $satoshis = 0;

        $confirmed_at = $model->confirmed_at->toDateString() . '%';

        $history = static::where('type', '=', 'price')
            ->where('asset', '=', 'BTC')
            ->where('quality_score', '=', 1)
            ->where('confirmed_at', 'like', $confirmed_at)
            ->latest('confirmed_at')
            ->first();

        if(! $history) return 0;

        return $history->value * $satoshis / 100000000;
    }
}
