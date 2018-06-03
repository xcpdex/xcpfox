<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MessageResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'block_index' => $this->block_index,
            'message_index' => $this->message_index,
            'command' => $this->command,
            'category' => getTitleFromType($this->category),
            'bindings' => json_decode($this->bindings),
            'block_time' => $this->confirmed_at,
            'block_time_ago' => $this->confirmed_at->diffForHumans(),
            'tx_hash' => $this->transaction ? $this->transaction->tx_hash : null,
            'transaction_url' => $this->transaction ? $this->transaction->url : null,
            'block_url' => $this->block_url,
            'url' => $this->url,
        ];
    }
}
