<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class BalanceResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $credits_count = \Cache::tags([$this->address . '_balances'])->rememberForever($this->address . '_' . $this->asset . '_credits', function () {
            return $this->addressModel->credits()->where('asset', '=', $this->asset)->count();
        });

        $debits_count = \Cache::tags([$this->address . '_balances'])->rememberForever($this->address . '_' . $this->asset . '_debits', function () {
            return $this->addressModel->debits()->where('asset', '=', $this->asset)->count();
        });

        return [
            'quantity' => number_format($this->quantity_normalized, 8),
            'percent' => number_format($this->quantity / $this->assetModel->issuance * 100, 8),
            'asset' => $this->assetModel->display_name,
            'asset_url' => $this->assetModel->url,
            'credits_count' => $credits_count,
            'debits_count' => $debits_count,
        ];
    }
}