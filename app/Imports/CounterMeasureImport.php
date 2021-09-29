<?php

namespace App\Imports;

use App\Models\Mrp\MrpCounterMeasure;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CounterMeasureImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function  collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MrpCounterMeasure::create(
            [
                'cm_code'  => $row[0] ?? "-",
                'cm_name'   => $row[1] ?? "-",
                'problem_id'   => $row[2] ?? "-",
                 'description'   => $row[3] ?? "-",
        ]

        );
    }
}
}