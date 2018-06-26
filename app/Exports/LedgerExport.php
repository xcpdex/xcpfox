<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LedgerExport implements FromCollection, WithTitle, WithMapping, WithHeadings
{
    use Exportable;
   
    protected $address;
    
    public function __construct($address)
    {
        $this->address = $address;
    }

    public function collection()
    {
        $credits = \App\Credit::query()
                 ->where('address', '=', $this->address)
                 ->get();

        $debits = \App\Debit::query()
                 ->where('address', '=', $this->address)
                 ->get();

        return $credits->merge($debits)->sortByDesc('confirmed_at');
    }
    
    public function headings(): array
    {
        return [
            'Block',
            'Created (UTC)',
            'Type',
            'Action',
            'Quantity',
            'Asset',
            'Tx 1',
            'Tx 2',
        ];
    }
    
    public function map($row): array
    {
        $txs = explode('_', $row->event);

        return [
            $row->block_index,
            $row->confirmed_at,
            $row instanceof \App\Credit ? 'Credit' : 'Debit',
            title_case($row->action),
            $row->quantity_normalized,
            $row->asset,
            $txs[0],
            isset($txs[1]) ? $txs[1] : '',
        ];
    }

    public function title(): string
    {
        return 'Account Ledger';
    }
}