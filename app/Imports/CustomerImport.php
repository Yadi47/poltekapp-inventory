<?php

namespace App\Imports;

use App\Models\Mrp\MrpCustomer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CustomerImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MrpCustomer::create(
                [
                    'customer_code' => $row[0] ?? "-", 
                    'customer_name' => $row[1] ?? "-",
                    'address' => $row[2] ?? "-",
                    'email' => $row[3] ?? "-",
                    'website' => $row[4] ?? "-",
                    

                ]
            );
        }
    }
}
