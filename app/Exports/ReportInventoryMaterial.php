<?php

namespace App\Exports;

use App\Models\Mrp\MrpReportProduction;
use App\Models\Mrp\MrpPlanningProduction;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportProduction implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View{
        return view('mrp.inventories.reports.report_inventory_material_excel');
    }
}
