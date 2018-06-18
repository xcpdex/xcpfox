<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $primaryKey = 'address';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address', 'type', 'options', 'block_index', 'burn', 'confirmed_at',
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
        'url',
    ];

    /**
     * URL
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url(route('addresses.show', ['address' => $this->address]));
    }

    /**
     * Issued Assets
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function issuedAssets()
    {
        return $this->hasMany(Asset::class, 'issuer');
    }

    /**
     * Owned Assets
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ownedAssets()
    {
        return $this->hasMany(Asset::class, 'owner');
    }

    /**
     * Balances
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function balances()
    {
        return $this->hasMany(Balance::class, 'address');
    }

    /**
     * Balances (Current)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function currentBalances()
    {
        return $this->hasMany(Balance::class, 'address')->whereCurrent('1');
    }

    /**
     * Bets
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bets()
    {
        return $this->hasMany(Bet::class, 'source');
    }

    /**
     * Broadcasts
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function broadcasts()
    {
        return $this->hasMany(Broadcast::class, 'source');
    }

    /**
     * Credits
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function credits()
    {
        return $this->hasMany(Credit::class, 'address');
    }

    /**
     * Debits
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function debits()
    {
        return $this->hasMany(Debit::class, 'address');
    }

    /**
     * Dividends
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dividends()
    {
        return $this->hasMany(Dividend::class, 'source');
    }

    /**
     * Issuances
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function issuances()
    {
        return $this->hasMany(Issuance::class, 'issuer');
    }

    /**
     * Orders
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'source');
    }

    /**
     * Sends
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sends()
    {
        return $this->hasMany(Send::class, 'source');
    }

    /**
     * Transactions
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'source');
    }

    /**
     * First or Create Address
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Address
     */
    public static function firstOrCreateAddress($message, $bindings)
    {
        // Known Column Names
        $address_columns = ['source', 'address', 'issuer', 'destination', 'tx0_address', 'tx1_address'];

        // Needle in Haystack
        foreach($address_columns as $address)
        {
            // Found a Needle
            if(isset($bindings[$address]))
            {
                $type = getAddressType($bindings[$address]);

                // Create Address
                $address = static::firstOrCreate([
                    'address' => $bindings[$address],
                ],[
                    'type' => $type,
                    'options' => 0,
                    'block_index' => $bindings['block_index'],
                    'confirmed_at' => $bindings['confirmed_at'],
                ]);

                if($type === 'multisig')
                {
                    $addresses =  array_values(array_filter(explode('_', $bindings[$address]), 'remove_keys'));

                    foreach($addresses as $address)
                    {
                        $type = getAddressType($address);

                        // Create Address
                        $address = static::firstOrCreate([
                            'address' => $address,
                        ],[
                            'type' => $type,
                            'options' => 0,
                            'block_index' => $bindings['block_index'],
                            'confirmed_at' => $bindings['confirmed_at'],
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Update Address Options
     *
     * @param  arr  $bindings
     * @return \App\Address
     */
    public static function updateAddressOptions($bindings)
    {
        static::updateOrCreate([
            'address' => $bindings['address'],
        ],[
            'options' => $bindings['options'],
            'confirmed_at' => $bindings['confirmed_at'],
        ]);
    }
}
