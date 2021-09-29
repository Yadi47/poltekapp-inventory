<?php

namespace App\Imports;

use App\Models\Mrp\MrpBom;
use App\Models\Mrp\MrpBomMaterial;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BomImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MrpBomMaterial::create(
                [
                    'bom_id' => $row[0] ?? null, 
                    'material_id' => $row[1] ?? null,

                ]
            );
        }
    }
}
