<?php

namespace App\Imports;

use App\Models\Mrp\MrpInventoryMaterialList;
use App\Models\Mrp\MrpInventoryProductList;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class InventoryMaterialImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MrpInventoryProductList::create(
                [
                    'product_id' => $row[0] ?? 0,
                    'stock' => $row[1] ?? 0,
                    'status' => $row[2] ?? '-',

                ]
            );
        }
    }
}
