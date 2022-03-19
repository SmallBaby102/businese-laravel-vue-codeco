<?php

namespace App\Imports;

use App\Models\InContainer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
class EstimateDataReport implements ToModel,WithHeadingRow
{
    use Importable;
    public function model(array $row)
    {
        return new InContainer([
            'containerno' => $row[0],
            'indate' => $row[1],
            'estdate' => $row[2],
            'estamt' => $row[3],
            'apdate' => $row[4],
            'apamt' => $row[5],
            'avdate' => $row[6]  
        ]);
    }
}
