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
        'asset_name', 'asset_longname', 'type', 'issuer', 'owner', 'description', 'issuance', 'issuance_normalized', 'divisible', 'locked', 'block_index', 'tx_index', 'meta', 'confirmed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
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
        'url', 'block_url', 'owner_url',
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
     * Owner URL
     *
     * @return string
     */
    public function getOwnerUrlAttribute()
    {
        return url(route('addresses.show', ['address' => $this->owner]));
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
        return $this->hasMany(Balance::class, 'asset', 'asset_name')->current();
    }

    /**
     * Credits
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function credits()
    {
        return $this->hasMany(Credit::class, 'asset', 'asset_name');
    }

    /**
     * Debits
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function debits()
    {
        return $this->hasMany(Debit::class, 'asset', 'asset_name');
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
     * First Or Create Asset
     *
     * @param  \App\Issuance  $issuance
     * @return \App\Asset
     */
    public static function firstOrCreateAsset(\App\Issuance  $issuance)
    {
        $type = getAssetType($issuance);

        return static::firstOrCreate([
            'asset_name' => $issuance->asset,
        ],[
            'type' => $type,
            'owner' => $issuance->source,
            'issuer' => $issuance->issuer,
            'asset_longname' => $issuance->asset_longname,
            'description' => $issuance->description,
            'issuance' => $issuance->quantity,
            'issuance_normalized' => $issuance->divisible ? fromSatoshi($issuance->quantity) : $issuance->quantity,
            'divisible' => $issuance->divisible,
            'locked' => $issuance->locked,
            'block_index' => $issuance->block_index,
            'tx_index' => $issuance->tx_index,
            'confirmed_at' => $issuance->confirmed_at,
        ]);
    }
}
