<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetExport implements WithMultipleSheets
{
    private $start,$end,$shipping;
    public function __construct(string $start,string $end,string $shipping)
    {
        $this->start = $start;
        $this->end = $end;
        $this->shipping = $shipping;
    }
    public function sheets(): array
    {
        $sheets = [];
        for ($month=1; $month <=5 ; $month++) { 
            $sheets[] = new TotatlInOutExport($month,$this->start,$this->end,$this->shipping);
        }
        return $sheets;
    }
}
