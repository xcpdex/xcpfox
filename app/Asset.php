<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $primaryKey = 'asset_name';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asset_name', 'asset_longname', 'type', 'issuer', 'owner', 'description', 'issuance', 'issuance_normalized', 'divisible', 'locked', 'block_index', 'message_index', 'confirmed_at',
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
        'url', 'block_url',
        'display_name',
    ];

    /**
     * URL
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url(route('assets.show', ['asset' => $this->display_name]));
    }

    /**
     * Block URL
     *
     * @return string
     */
    public function getBlockUrlAttribute()
    {
        return url(route('blocks.show', ['block_hash' => $this->block_index]));
    }

    /**
     * Display Name
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return $this->asset_longname ? $this->asset_longname : $this->asset_name;
    }

    /**
     * Balances
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function balances()
    {
        return $this->hasMany(Balance::class, 'asset', 'asset_name');
    }

    /**
     * Current Balances
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function currentBalances()
    {
        return $this->hasMany(Balance::class, 'asset', 'asset_name')->whereCurrent(1)->where('quantity', '>', 0);
    }

    /**
     * Dividends
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dividends()
    {
        return $this->hasMany(Dividend::class, 'asset', 'asset_name');
    }

    /**
     * Issuances
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function issuances()
    {
        return $this->hasMany(Issuance::class, 'asset', 'asset_name');
    }

    /**
     * Sends
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sends()
    {
        return $this->hasMany(Send::class, 'asset', 'asset_name');
    }

    /**
     * Update or Create Asset
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Asset
     */
    public static function updateOrCreateAsset($message, $bindings)
    {
        if($bindings['status'] === 'valid')
        {
            \Cache::tags(['issuance_flush'])->flush();

            if($asset = static::whereAssetName($bindings['asset'])->first())
            {
                return $asset->updateAsset($message, $bindings);
            }
            else
            {
                return static::createAsset($message, $bindings);
            }
        }
    }

    /**
     * Create Asset
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Asset
     */
    public static function createAsset($message, $bindings)
    {
        $type = getAssetType($bindings);

        return static::firstOrCreate([
            'asset_name' => $bindings['asset'],
        ],[
            'type' => $type,
            'owner' => $bindings['source'],
            'issuer' => $bindings['issuer'],
            'asset_longname' => $bindings['asset_longname'],
            'description' => $bindings['description'],
            'issuance' => $bindings['quantity'],
            'issuance_normalized' => $bindings['divisible'] ? fromSatoshi($bindings['quantity']) : $bindings['quantity'],
            'divisible' => $bindings['divisible'],
            'locked' => $bindings['locked'],
            'block_index' => $bindings['block_index'],
            'message_index' => $message['message_index'],
            'confirmed_at' => $bindings['confirmed_at'],
        ]);
    }

    /**
     * Update Asset
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Asset
     */
    public function updateAsset($message, $bindings)
    {
        if(isset($bindings['quantity']))
        {
            $issuance = $this->issuance + $bindings['quantity'];
            $issuance_normalized = $this->divisible ? fromSatoshi($issuance) : $issuance;

            if($issuance > 9223372036854775807)
            {
                $issuance = 9223372036854775807;
                $issuance_normalized = fromSatoshi(9223372036854775807);
            }
        }

        return $this->update([
            'issuer' => $bindings['issuer'],
            'description' => $bindings['description'],
            'issuance' => isset($issuance) ? $issuance : $this->issuance,
            'issuance_normalized' => isset($issuance_normalized) ? $issuance_normalized : $this->issuance_normalized,
            'locked' => ! $this->locked && $bindings['locked'] ? 1 : $this->locked,
            'confirmed_at' => $bindings['confirmed_at'],
        ]);
    }
}
