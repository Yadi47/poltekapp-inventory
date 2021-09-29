<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpProcess extends Model
{
    use HasFactory;

    protected $table = 'mrp_process';

    protected $guarded = [];

    public function machine()
    {
        return $this->belongsTo(MrpMachine::class);
    }

    public function product()
    {
        return $this->belongsTo(MrpProduct::class);
    }

    public function planningProductions()
    {
        return $this->belongsToMany(MrpPlanningProduction::class, 'mrp_planning_production_process', 'process_id');
    }

    public function processMachines()
    {
        return $this->belongsToMany(MrpMachine::class, 'mrp_process_machines', 'process_machines_id', 'machine_id');
    }

    public function productions()
    {
        return $this->belongsToMany(MrpProduction::class, 'mrp_production_process');
    }
    
    
    // public function production()
    // {
    //     return $this->belongsToMany(MrpProduction::class);
    // }
}
