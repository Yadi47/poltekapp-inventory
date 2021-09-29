<?php

namespace App\Imports;

use App\Models\Mrp\MrpProblem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProblemsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            MrpProblem::create(
            [
                'problem_code'  => $row[0] ?? "-",
                'problem_name'   => $row[1] ?? "-",
                 'description'     => $row[2] ?? "-",
        ]

        );
    }
}
}