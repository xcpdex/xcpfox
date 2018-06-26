<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'address';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'block_index',
        'address',
        'type',
        'options',
        'burn',
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
        return $this->hasMany(Balance::class, 'address')->current();
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
     * Create Addresses
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Address
     */
    public static function createAddresses($message, $bindings)
    {
        // Needles
        $address_columns = [
            'source',
            'issuer',
            'address',
            'destination',
            'tx0_address',
            'tx1_address'
        ];

        // Haystack
        foreach($address_columns as $address)
        {
            // Needle in Haystack
            if(isset($bindings[$address]))
            {
                // Create Address
                $address = static::firstOrCreateAddress($bindings[$address], $bindings);

                // Split Multisig
                if($address->type === 'multisig')
                {
                    $addresses = array_values(array_filter(explode('_', $bindings[$address]), 'remove_keys'));

                    // Create Addresses
                    foreach($addresses as $address)
                    {
                        static::firstOrCreateAddress($address, $bindings);
                    }
                }
            }
        }
    }

    /**
     * First or Create Address
     *
     * @param  arr  $address
     * @param  arr  $bindings
     * @return \App\Address
     */
    public static function firstOrCreateAddress($address, $bindings)
    {
        return static::firstOrCreate([
            'address' => $address,
        ],[
            'type' => getAddressType($address),
            'options' => 0,
            'block_index' => $bindings['block_index'],
            'confirmed_at' => $bindings['confirmed_at'],
         ]);
    }

    /**
     * Update Address Options
     *
     * @param  arr  $bindings
     * @return \App\Address
     */
    public static function updateAddressOptions($bindings)
    {
        return static::updateOrCreate([
            'address' => $bindings['address'],
        ],[
            'options' => $bindings['options'],
            'confirmed_at' => $bindings['confirmed_at'],
        ]);
    }
}