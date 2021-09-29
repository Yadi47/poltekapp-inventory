<?php

namespace App\Imports;

use App\Models\Mrp\MrpVehicle;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class VehiclesImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row) {
            MrpVehicle::create(
            [
                'car_code' => $row[0] ?? "-",
                'type' => $row[1] ?? "-",
              'driver' => $row[2] ?? "-",
         'description' => $row[3] ?? "-",
        ]
    );
}
    }
}
