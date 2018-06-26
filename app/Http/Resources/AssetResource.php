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
            'type' => $this->type,
            'display_name' => $this->display_name,
            'description' => $this->description,
            'issuance_normalized' => number_format($this->issuance_normalized, 8),
            'locked' => $this->locked,
            'owner' => $this->owner,
            'holders' => number_format($this->current_balances_count),
            'block_time_ago' => $this->confirmed_at->diffForHumans(),
            'owner_url' => $this->ownerAddress->url,
            'url' => $this->url,
        ];
    }
}
