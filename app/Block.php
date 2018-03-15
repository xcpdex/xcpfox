<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $primaryKey = 'block_index';
    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'block_index', 'block_hash', 'ledger_hash', 'txlist_hash', 'messages_hash', 'previous_block_hash', 'difficulty', 'block_time',
    ];
}