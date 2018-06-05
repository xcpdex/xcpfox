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
            'block_height' => $this->block_index,
            'display_name' => $this->display_name,
            'description' => $this->description,
            'issuance' => $this->issuance,
            'issuance_normalized' => number_format($this->issuance_normalized, 8),
            'divisible' => $this->divisible,
            'locked' => $this->locked,
            'block_time' => $this->confirmed_at,
            'block_time_ago' => $this->confirmed_at->diffForHumans(),
            'block_url' => $this->block_url,
            'url' => $this->url,
        ];
    }
}
