<?php

namespace App\Imports;

use App\Models\ial_upload;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
class ial_upload_import implements ToModel,WithHeadingRow
{
    use Importable;
    /**
    * @param array $row 
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    { 
        return new ial_upload([
            'container_no' => $row[0],
            'size' => $row[1],
            'type' => $row[2] 
        ]);
    }
}
