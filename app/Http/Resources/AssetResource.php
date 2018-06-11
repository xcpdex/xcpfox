<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AssetResource extends Resource
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
            'block_height' => number_format($this->block_index),
            'type' => $this->type,
            'display_name' => $this->display_name,
            'description' => $this->description,
            'issuance' => $this->issuance,
            'issuance_normalized' => number_format($this->issuance_normalized, 8),
            'divisible' => $this->divisible,
            'locked' => $this->locked,
            'owner' => $this->owner,
            'holders' => number_format($this->current_balances_count),
            'block_time' => $this->confirmed_at,
            'block_time_ago' => $this->confirmed_at->diffForHumans(),
            'block_url' => $this->block_url,
            'owner_url' => $this->owner_url,
            'url' => $this->url,
        ];
    }
}
