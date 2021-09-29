<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpReportProduction extends Model
{
    use HasFactory;

    protected $table = 'mrp_report_productions';

    // protected $fillable = [
    //     'bom_id', 'shift_id', 'production_code', 'production_name', 'plan_code', 'plan_name', 'qty_plan', 'qty_entry', 'qty_reject', 'qty_good', 'date_start', 'date_finish', 'problem_id', 'counter_measure_id', 'proces_id',
    //     'bom_id','shift_id','production_code','production_name','planning_id','qty_plan','qty_entry','qty_reject','qty_good','date_start','date_finish','problem_id','counter_measure_id','proces_id',
    // ];
    protected $guarded = [''];


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
