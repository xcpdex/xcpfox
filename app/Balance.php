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
        'address', 'asset', 'quantity', 'quantity_usd',
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
     * @param  str  $debit_or_credit
     * @return \App\Balance
     */
    public static function updateOrCreateBalance($message, $bindings, $debit_or_credit)
    {
        try
        {
            // Current Balance
            $balance = static::whereAsset($bindings['asset'])
                ->whereAddress($bindings['address'])
                ->first();

            // Current Balance +/- Change
            if($balance && $debit_or_credit === 'credit')
            {
                $quantity = bcadd($balance->quantity, $bindings['quantity']);
            }
            elseif($balance && $debit_or_credit === 'debit')
            {
                $quantity = bcsub($balance->quantity, $bindings['quantity']);
            }
            else
            {
                $quantity = $bindings['quantity'];
            }

            return static::updateOrCreate([
               'asset' => $bindings['asset'],
               'address' => $bindings['address'],
            ],[
                'quantity' => $quantity,
            ]);
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Balance: ' . $message['message_index'] . ' ' . $debit_or_credit . ' ' . $quantity . ' ' . serialize($e->getMessage()));
        }
    }
}
