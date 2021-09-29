<?php

namespace App\Imports;

use App\Models\Mrp\MrpProcess;
use App\Models\Mrp\MrpProcessMachine;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProcessImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $i=> $row) {
            if($i==0){
                continue;
            }
            MrpProcessMachine::create(
                [
                    'process_machines_id' => $row[0] ?? "-", 
                    'machine_id' => $row[1] ?? "-",

                ]
            );
        }
    }
}
