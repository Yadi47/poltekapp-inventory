<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpReportPlanningProduction extends Model
{
    use HasFactory;

    public function machine()
    {
        return $this->belongsTo(MrpMachine::class);
    }

    public function production()
    {
        return $this->belongsTo(MrpProduction::class);
    }

    public function shift()
    {
        return $this->belongsTo(MrpShift::class);
    }
    public function planning_production()
    {
        return $this->belongsTo(MrpPlanningProduction::class);
    }
}
