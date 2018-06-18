<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey = 'message_index';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'message_index', 'block_index', 'command', 'category', 'bindings', 'timestamp', 'confirmed_at',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'bindings' => 'array',
    ];

    /**
     * The attributes that are appended.
     *
     * @var array
     */
    protected $appends = [
        'url', 'block_url',
    ];

    /**
     * URL
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url(route('messages.show', ['message' => $this->message_index]));
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
     * Block
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function block()
    {
        return $this->belongsTo(Block::class, 'block_index', 'block_index');
    }

    /**
     * Transaction
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'message_index', 'message_index');
    }

    /**
     * First or Create Message
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Asset
     */
    public static function firstOrCreateMessage($message, $bindings)
    {
        return static::firstOrCreate([
            'message_index' => $message['message_index'],
        ],[
            'block_index' => $message['block_index'],
            'command' => $message['command'],
            'category' => isset($message['category']) ? $message['category'] : '',
            'bindings' => $message['bindings'],
            'timestamp' => $message['timestamp'],
            'confirmed_at' => $bindings['confirmed_at'],
        ]);
    }
}