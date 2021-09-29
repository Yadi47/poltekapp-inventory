<?php

namespace App\Imports;

use App\Models\Mrp\MrpMaterial;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MaterialImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MrpMaterial::create(
                [
                    'material_code' => $row[0] ?? "-", 
                    'material_name' => $row[1] ?? "-",
                    'part_number' => $row[2] ?? "-",
                    'dim_long' => $row[3] ?? "-",
                    'dim_width' => $row[4] ?? "-",
                    'dim_height' => $row[5] ?? "-",
                    'dim_weight' => $row[6] ?? "-",
                    'supplier_id' => $row[7] ?? "-",
                    'unit_id' => $row[8] ?? "-",
                    'description' => $row[9] ?? "-",

                ]
            );
        }
    }
}
