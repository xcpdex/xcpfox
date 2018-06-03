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
     * Balances
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function balances()
    {
        return $this->hasMany(Balance::class, 'address');
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
     * Issuances
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function issuances()
    {
        return $this->hasMany(Issuance::class, 'issuer');
    }

    public function getBalance($asset)
    {
        return $this->balances()->asset($asset)->orderBy('message_index', 'desc')->first();
    }

    public function getBalanceHistory($asset)
    {
        return $this->balances()->asset($asset)->orderBy('message_index', 'desc')->get();
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
        try
        {
            // Known Column Names
            $address_fields = ['source', 'address', 'issuer', 'destination', 'tx0_address', 'tx1_address'];

            // Needle in Haystack
            foreach($address_fields as $address_field)
            {
                // Found a Needle
                if(isset($bindings[$address_field]))
                {
                    $type = static::getAddressType($bindings[$address_field]);

                    // Create Address
                    return static::firstOrCreate([
                        'address' => $bindings[$address_field],
                    ],[
                        'type' => $type,
                        'options' => 0,
                        'block_index' => $bindings['block_index'],
                        'confirmed_at' => $bindings['confirmed_at'],
                    ]);
                }
            }
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Address: ' . $message['message_index'] . ' ' . serialize($e->getMessage()));
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
        try
        {
            static::updateOrCreate([
                'address' => $bindings['address'],
            ],[
                'options' => $bindings['options'],
            ]);
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Replace: ' . $bindings['address'] . ' ' . serialize($e->getMessage()));
        }
    }

    public static function getAddressType($address)
    {
        if(strpos($address, '_') !== false)
        {
            return 'multisig';
        }
        elseif($address[0] === '1')
        {
            return 'p2pkh';
        }
        elseif($address[0] === '3')
        {
            return 'p2sh';
        }
        elseif($address[0] === 'b')
        {
            return 'bech32';
        }

        return 'unknown';
    }
}
