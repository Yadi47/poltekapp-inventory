<?php

namespace App\Imports;

use App\Models\Oee\OeeAlarmDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AlarmDetailImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            OeeAlarmDetail::create(
                [
                    'id' => $row[0] ?? "-",
                    'index_array' => $row[1] ?? "-",
                    'text' => $row[2] ?? ' ',
                ]
            );
        }
    }
}
