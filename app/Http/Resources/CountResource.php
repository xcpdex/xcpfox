<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CountResource extends Resource
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
                $this->count,
            ];
        }
        elseif(isset($this->month))
        {
            return [
                $this->year . '-' . $this->month,
                $this->count,
            ];
        }
        elseif(isset($this->year))
        {
            return [
                $this->year,
                $this->count,
            ];
        }
    }
}
