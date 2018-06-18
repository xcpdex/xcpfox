<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MempoolResource extends Resource
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
            'type' => getTitleFromType($this->category),
            'tx_hash' => $this->tx_hash,
            'tx_data' => json_decode($this->bindings),
            'block_time_ago' => \Carbon\Carbon::createFromTimestamp($this->timestamp)->diffForHumans(),
            'url' => $this->url,
        ];
    }
}
