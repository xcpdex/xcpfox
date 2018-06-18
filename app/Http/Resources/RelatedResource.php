<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class RelatedResource extends Resource
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
            $this->asset,
            (float) $this->percent,
            $this->count,
        ];
    }
}
