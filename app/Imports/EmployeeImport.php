<?php

namespace App\Imports;

use App\Models\Mrp\MrpEmployee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EmployeeImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MrpEmployee::create(
                [
                    'nik' => $row[0] ?? "-", 
                    'employee_name' => $row[1] ?? "-",
                    'departement' => $row[2] ?? "-",
                    'section' => $row[3] ?? "-",
                    'title' => $row[4] ?? "-",
                    'grade' => $row[5] ?? "-",
                    'shift_id' => $row[6] ?? "-",
                    'place_id' => $row[7] ?? "-",

                ]
            );
        }
    }
}
