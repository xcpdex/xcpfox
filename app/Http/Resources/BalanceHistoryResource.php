<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BalanceHistoryResource extends Resource
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
            $this->confirmed_at->timestamp * 1000,
            (float) $this->quantity_normalized,
        ];
    }
}