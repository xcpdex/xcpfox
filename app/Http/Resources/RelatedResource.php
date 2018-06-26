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
        $display_name = \Cache::rememberForever($this->asset . '_display_name', function () {
            return \App\Asset::find($this->asset)->display_name;
        });

        return [
            $display_name,
            (float) $this->percent,
            $this->count,
        ];
    }
}
