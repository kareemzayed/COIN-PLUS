<?php

namespace App\Exports;

use App\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockExportByRange implements FromCollection, WithMapping, WithHeadings
{

    private $dates;
    function __construct($dates)
    {
        $this->dates = $dates;
    }
    public function headings(): array
    {
        return [
            'id',
            'Name',
            'Date Made',
            'Raw Meat Quantity',
            'Wastage',
            'Serve Per Portion',
            'Number Of Serve',
            'Current Stock',
            'Total Stock',
            'Sold',
            'Current Stock',
        ];
    }


    public function map($stock): array
    {
        return [
            $stock->id,
            $stock->recipe->name,
            $stock->date->format('Y-m-d'),
            $stock->raw_meat,
            $stock->wastage,
            $stock->serve,
            $stock->number_of_serve,
            $stock->current_stock,
            $stock->total_stock,
            $stock->sold,
            $stock->current_stock_end,
        ];
    }

    public function collection()
    {
        return Stock::whereBetween('date', $this->dates)->get();
    }
}
