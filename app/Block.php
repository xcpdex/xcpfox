<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $primaryKey = 'block_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'block_index', 'block_hash', 'ledger_hash', 'txlist_hash', 'messages_hash', 'previous_block_hash', 'next_block_hash', 'merkle_root', 'chainwork', 'difficulty', 'timestamp', 'nonce', 'size', 'stripped_size', 'weight', 'tx_count', 'processed_at', 'confirmed_at',
    ];

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = [
        'processed_at', 'confirmed_at',
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
        return url(route('blocks.show', ['block_hash' => $this->block_hash]));
    }

    /**
     * Messages
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'block_index', 'block_index');
    }

    /**
     * Transactions
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'block_index', 'block_index');
    }

    /**
     * Sends
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sends()
    {
        return $this->hasMany(Send::class, 'block_index', 'block_index');
    }

    /**
     * First or Create Block
     *
     * @param  arr  $data
     * @return \App\Block
     */
    public static function firstOrCreateBlock($data)
    {
        \Cache::tags(['block_flush'])->flush();

        return static::firstOrCreate([
            'block_index' => $data['block_index'],
        ],[
            'block_hash' => $data['block_hash'],
            'ledger_hash' => $data['ledger_hash'],
            'txlist_hash' => $data['txlist_hash'],
            'messages_hash' => $data['messages_hash'],
            'previous_block_hash' => $data['previous_block_hash'],
            'difficulty' => $data['difficulty'],
            'timestamp' => $data['block_time'],
            'confirmed_at' => \Carbon\Carbon::createFromTimestamp($data['block_time']),
        ]);
    }

    /**
     * Update Block
     *
     * @param  arr  $data
     * @return \App\Block
     */
    public function updateBlock($data)
    {
        $this->update([
            'next_block_hash' => isset($data['nextblockhash']) ? $data['nextblockhash'] : null,
            'merkle_root' => $data['merkleroot'],
            'chainwork' => $data['chainwork'],
            'nonce' => $data['nonce'],
            'size' => $data['size'],
            'stripped_size' => $data['strippedsize'],
            'weight' => $data['weight'],
            'tx_count' => count($data['tx']),
            'confirmed_at' => $this->confirmed_at,
            'processed_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}