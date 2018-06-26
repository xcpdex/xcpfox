<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class HistoryExport implements WithMultipleSheets
{
    use Exportable;

    protected $address;

    public function __construct($address)
    {
        $this->address = $address;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            new BalanceExport($this->address),
            new LedgerExport($this->address),
            new TransactionExport($this->address),
        ];
    }
}