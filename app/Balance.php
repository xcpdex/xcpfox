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
     * Asset Data
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assetData()
    {
        return $this->belongsTo(Asset::class, 'asset', 'asset_name');
    }

    /**
     * Scope a query to only include balances of an asset.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string  $asset
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAsset($query, $asset)
    {
        return $query->whereAsset($asset);
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
        try
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
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Balance: ' . serialize($e->getMessage()));
        }
    }
}