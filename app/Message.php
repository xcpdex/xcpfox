<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey = 'message_index';
    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'message_index', 'block_index', 'command', 'category', 'bindings', 'timestamp',
    ];
}
