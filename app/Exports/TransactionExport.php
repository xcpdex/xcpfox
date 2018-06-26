<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionExport implements FromCollection, WithTitle, WithMapping, WithHeadings
{
    use Exportable;
   
    protected $address;
    
    public function __construct($address)
    {
        $this->address = $address;
    }

    public function collection()
    {
        return \App\Transaction::where('source', '=', $this->address)
            ->latest('confirmed_at')
            ->get();
    }
    
    public function headings(): array
    {
        return [
            'Block',
            'Created (UTC)',
            'Type',
            'Quantity (BTC)',
            'Quantity (USD)',
            'Fee (BTC)',
            'Fee (USD)',
            'Size (Bytes)',
            'Fee Rate',
            'Valid',
            'Tx Hash',
        ];
    }
    
    public function map($row): array
    {
        return [
            $row->block_index,
            $row->confirmed_at,
            getTitleFromType($row->type),
            $row->quantity_normalized,
            $row->quantity_usd_normalized,
            $row->fee_normalized,
            $row->fee_usd_normalized,
            $row->size,
            round($row->fee / $row->size),
            $row->valid ? 'True' : 'False',
            $row->tx_hash,
        ];
    }

    public function title(): string
    {
        return 'Bitcoin Transactions';
    }
}