<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class QuantityTwoResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        if(isset($this->date))
        {
            return [
                \Carbon\Carbon::createFromFormat('Y-m-d', $this->date)->timestamp * 1000,
                (float) $this->quantity,
            ];
        }
        elseif(isset($this->month))
        {
            return [
                $this->year . '-' . $this->month,
                (float) $this->quantity,
            ];
        }
        elseif(isset($this->year))
        {
            return [
                $this->year,
                (float) $this->quantity,
            ];
        }
    }
}
