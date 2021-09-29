<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpPlanningProductionProcess extends Model
{
    use HasFactory;

    protected $table = 'mrp_planning_production_process';

    protected $guarded = [];

    public function planning()
    {
        return $this->belongsTo(MrpPlanningProduction::class);
    }

    public function process()
    {
        return $this->belongsTo(MrpProcess::class, 'process_id');
    }

    public function products()
    {
        return $this->belongsToMany(MrpProduct::class,'mrp_products','product_id');
    }

    public function boms()
    {
        return $this->belongsTo(MrpBom::class,'bom_id');
    }

    public function machines()
    {
        return $this->belongsTo(MrpMachines::class,'machine_id');
    }

    public function productionProcess()
    {
        return $this->belongsTo(MrpProductionProcess::class);
    }
}
