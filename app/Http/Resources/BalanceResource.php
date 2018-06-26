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
        $credits = \Cache::tags([$this->address . '_balances'])->rememberForever($this->address . '_' . $this->asset . '_credited', function () {
            return $this->addressModel->credits()->where('asset', '=', $this->asset)->sum('quantity');
        });

        $debits = \Cache::tags([$this->address . '_balances'])->rememberForever($this->address . '_' . $this->asset . '_debited', function () {
            return $this->addressModel->debits()->where('asset', '=', $this->asset)->sum('quantity');
        });

        return [
            'quantity' => $this->quantity,
            'quantity_normalized' => number_format($this->quantity_normalized, 8),
            'percent' => number_format($this->quantity / $this->assetModel->issuance * 100, 8),
            'asset' => $this->assetModel->display_name,
            'asset_url' => $this->assetModel->url,
            'credits' => $credits,
            'credits_normalized' => $this->assetModel->divisible ? number_format(fromSatoshi($credits), 8) : number_format($credits, 8),
            'debits' => $debits,
            'debits_normalized' => $this->assetModel->divisible ? number_format(fromSatoshi($debits), 8) : number_format($debits, 8),
            'block_time' => $this->confirmed_at->toFormattedDateString(),
            'block_time_ago' => $this->confirmed_at->diffForHumans(),
        ];
    }
}