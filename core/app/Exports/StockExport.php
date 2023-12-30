<?php

namespace App\Exports;

use App\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
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


    public function map($stock) : array {
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
        ] ;
 
 
    }

    public function collection()
    {
        return Stock::all();
    }
}
