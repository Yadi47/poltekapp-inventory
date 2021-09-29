<?php

namespace App\Imports;

use App\Models\Mrp\MrpPlace;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PlaceImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MrpPlace::create(
                [
                    'place_code' => $row[0] ?? "-", 
                    'place_name' => $row[1] ?? "-",

                ]
            );
        }
    }
}
