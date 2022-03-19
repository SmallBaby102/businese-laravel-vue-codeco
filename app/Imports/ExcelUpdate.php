<?php

namespace App\Imports;

use App\Models\InContainer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
class ExcelUpdate implements ToModel,WithHeadingRow
{
    use Importable;
    public function model(array $row)
    {
        return new InContainer([
            'shipper' => $row[0],
            'containerno' => $row[1],
            'indate' => $row[2],
            'outdate' => $row[3],
            'value' => $row[4],
        ]);
    }
}
