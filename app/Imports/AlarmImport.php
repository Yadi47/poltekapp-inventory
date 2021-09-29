<?php

namespace App\Imports;

use App\Models\Oee\OeeAlarms;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


class AlarmImport implements ToCollection
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
            OeeAlarms::create(
                [
                    'alarm_master_id' => $row[0] ?? "-",
                    'alarm_detail_id' => $row[1] ?? "-",
                    // 'alarm_tag' => $row[2] ?? '-',
                ]
            );
        }
    }
}
