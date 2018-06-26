<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BalanceExport implements FromCollection, WithTitle, WithMapping, WithHeadings
{
    use Exportable;
   
    protected $address;
    
    public function __construct($address)
    {
        $this->address = $address;
    }

    public function collection()
    {
        return \App\Balance::where('address', '=', $this->address)
            ->with('assetModel')
            ->where('current', '=', 1)
            ->orderBy('asset', 'asc')
            ->get();
    }
    
    public function headings(): array
    {
        return [
            'Last Changed (UTC)',
            'Asset',
            'Quantity',
        ];
    }
    
    public function map($row): array
    {
        return [
            $row->confirmed_at,
            $row->assetModel->display_name,
            $row->quantity_normalized,
        ];
    }

    public function title(): string
    {
        return 'Current Balance';
    }
}