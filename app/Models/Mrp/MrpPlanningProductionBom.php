<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpPlanningProductionBom extends Model
{
    use HasFactory;

    protected $table = 'mrp_planning_production_boms';

    protected $guarded = [];

    public function planning()
    {
        return $this->belongsTo(MrpPlanningProduction::class);
    }

    public function boms()
    {
        return $this->belongsTo(MrpBom::class);
    }

    public function productionProcess()
    {
        return $this->hasMany(MrpProductionProcess::class);
    }

}