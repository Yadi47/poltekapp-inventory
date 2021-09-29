<?php

namespace App\Imports;

use App\Models\Mrp\MrpMachine;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MachineImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MrpMachine::create(
                [
                    'machine_code' => $row[0] ?? "-", 
                    'machine_name' => $row[1] ?? "-",
                    'type' => $row[2] ?? "-" ,
                    // 'brand' => $row[3] ?? "-",
                    // 'capacity' => $row[4] ?? "-",
                    'unit_id' => $row[3] ?? null,
                    'place_id' => $row[4] ?? null,

                ]
            );
        }
    }
}
