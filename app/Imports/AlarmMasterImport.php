<?php

namespace App\Imports;

use App\Models\Oee\OeeAlarmsMaster;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AlarmMasterImport implements ToCollection
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
            OeeAlarmsMaster::create(
                [
                    'machine_id' => $row[0] ?? "-",
                    'alarm_name' => $row[1] ?? "-",
                    'alarm_tag' => $row[2] ?? '-',
                ]
            );
        }
    }
}
