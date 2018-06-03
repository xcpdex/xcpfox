<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class AddressResource extends Resource
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
            'address' => $this->address,
            'type' => $this->type,
            'options' => $this->options,
            'burn' => $this->burn,
            'url' => $this->url,
        ];
    }
}
