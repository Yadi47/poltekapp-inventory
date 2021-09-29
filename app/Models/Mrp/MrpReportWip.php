<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpReportWip extends Model
{
    use HasFactory;
    
    protected $table = 'mrp_report_wips';

    protected $guarded = [''];

    public function production()
    {
        return $this->belongsTo(MrpProduction::class);
    }

    public function shift()
    {
        return $this->belongsTo(MrpShift::class);
    }

    public function machine()
    {
        return $this->belongsTo(MrpMachine::class);
    }
    
    public function product()
    {
        return $this->belongsTo(MrpProduct::class);
    }
    
    public function planning_production()
    {
        return $this->belongsTo(MrpPlanningProduction::class);
    }
    
    // public function process()
    // {
    //     return $this->belongsTo(MrpProcess::class, 'process_id', 'id');
    // }

    // public function collection()
    // {
    //     return MrpProduction::all();
    // }
}
