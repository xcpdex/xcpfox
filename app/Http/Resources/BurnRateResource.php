<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BurnRateResource extends Resource
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
            \Carbon\Carbon::createFromFormat('Y-m-d', $this->date)->timestamp * 1000,
            round($this->earned / $this->burned),
            $this->count,
        ];
    }
}
