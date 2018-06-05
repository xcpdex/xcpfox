<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address', 'asset', 'quantity', 'quantity_usd', 'message_index', 'block_index', 'quality_score', 'current', 'confirmed_at',
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
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = [
        'quantity_normalized', 'quantity_usd_normalized',
    ];

    /**
     * Quantity Normalized
     *
     * @return string
     */
    public function getQuantityNormalizedAttribute()
    {
        return $this->assetModel->divisible ? fromSatoshi($this->quantity) : sprintf("%.8f", $this->quantity);
    }

    /**
     * Quantity USD Normalized
     *
     * @return string
     */
    public function getQuantityUsdNormalizedAttribute()
    {
        return $this->assetModel->divisible ? fromSatoshi($this->quantity_usd) : $this->quantity_usd;
    }

    /**
     * Asset Data
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assetModel()
    {
        return $this->belongsTo(Asset::class, 'asset', 'asset_name');
    }

    /**
     * Update Current Balance
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Balance
     */
    public static function updateOrCreateBalance($message, $bindings)
    {
        // Last Balance
        $last_balance = static::where('address', '=', $bindings['address'])
            ->where('asset', '=', $bindings['asset'])
            ->where('current', '=', 1)
            ->orderBy('message_index', 'desc')
            ->first();

        $quantity = $bindings['quantity'];

        if($last_balance && $message['category'] === 'credits')
        {
            $quantity = $last_balance->quantity + $quantity;
        }

        if($last_balance && $message['category'] === 'debits')
        {
            $quantity = $last_balance->quantity - $quantity;
        }

        if($quantity < 0) $quantity = 0;

        static::firstOrCreate([
            'address' => $bindings['address'],
            'asset' => $bindings['asset'],
            'block_index' => $bindings['block_index'],
            'message_index' => $message['message_index'],
        ],[
            'current' => 1,
            'quantity' => $quantity,
            'quantity_usd' => 0,
            'confirmed_at' => $bindings['confirmed_at'],
        ]);

        if($last_balance) $last_balance->update(['current' => 0]);
    }
}