<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BlockResource extends Resource
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
            'block_height' => $this->block_index,
            'messages_count' => number_format($this->messages_count),
            'transactions_count' => number_format($this->transactions_count),
            'size' => number_format($this->size / 1000, 2),
            'weight' => number_format($this->weight / 1000, 2),
            'tx_count' => number_format($this->tx_count),
            'block_time' => $this->confirmed_at,
            'block_time_ago' => $this->confirmed_at->diffForHumans(),
            'url' => $this->url,
        ];
    }
}
