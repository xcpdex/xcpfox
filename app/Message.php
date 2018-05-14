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
}