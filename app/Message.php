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
     * Block
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function block()
    {
        return $this->belongsTo(Block::class, 'block_index', 'block_index');
    }


    /**
     * Update or Create Message
     *
     * @param  arr  $message
     * @param  arr  $bindings
     * @return \App\Asset
     */
    public static function updateOrCreateMessage($message, $block_time)
    {
        try
        {
            return static::updateOrCreate([
                'message_index' => $message['message_index'],
            ],[
                'block_index' => $message['block_index'],
                'command' => $message['command'],
                'category' => isset($message['category']) ? $message['category'] : '',
                'bindings' => $message['bindings'],
                'timestamp' => $message['timestamp'],
                'confirmed_at' => \Carbon\Carbon::createFromTimestamp($block_time, 'America/New_York'),
            ]);
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Message: ' . $message['message_index'] . ' ' . serialize($e->getMessage()));
        }
    }
}