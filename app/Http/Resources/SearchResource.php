<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SearchResource extends Resource
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
            'result' => $this->extra ? $this->extra : $this->result,
            'url' => $this->extra ? $this->url . '/' . $this->extra : $this->url . '/' . $this->result,
            'time_ago' => $this->confirmed_at->diffForHumans(),
        ];
    }
}
