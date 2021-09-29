<?php

namespace App\Imports;

use App\Models\Mrp\MrpShift;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ShiftsImport  implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function  collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MrpShift::create(
            [
                'shift_code' => $row[0] ?? "-",
                'shift_name' => $row[1] ?? "-",
                 'time_from' => $row[2] ?? "-",
                   'time_to' => $row[3] ?? "-",
                'running_operation' => $row[4] ?? "-",
                    'status' => $row[5] ?? "-",
                'description' => $row[6] ?? "-",
        ]
    );
}
    }
}
