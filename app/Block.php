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
         'block_index', 'block_hash', 'ledger_hash', 'txlist_hash', 'messages_hash', 'previous_block_hash', 'difficulty', 'timestamp', 'confirmed_at',
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
     * Update or Create Block
     *
     * @param  arr  $data
     * @return \App\Block
     */
    public static function updateOrCreateBlock($data)
    {
        try
        {
            return static::updateOrCreate([
                'block_index' => $data['block_index'],
            ],[
                'block_hash' => $data['block_hash'],
                'ledger_hash' => $data['ledger_hash'],
                'txlist_hash' => $data['txlist_hash'],
                'messages_hash' => $data['messages_hash'],
                'previous_block_hash' => $data['previous_block_hash'],
                'difficulty' => $data['difficulty'],
                'timestamp' => $data['block_time'],
                'confirmed_at' => \Carbon\Carbon::createFromTimestamp($data['block_time'], 'America/New_York'),
            ]);
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Block: ' . $data['block_index'] . ' ' . serialize($e->getMessage()));
        }
    }
}