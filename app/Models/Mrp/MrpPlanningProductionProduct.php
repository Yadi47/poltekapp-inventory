<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpPlanningProductionProduct extends Model
{
    use HasFactory;

    protected $table = 'mrp_planning_production_products';

    protected $guarded = [];

    public function planning()
    {
        return $this->belongsTo(MrpPlanningProduction::class);
    }


    // public function products()
    // {
    //     return $this->belongsTo(MrpProduct::class);
    // }

    public function product()
    {
        return $this->belongsTo(MrpProduct::class, 'product_id');
    }

    public function productionProcess()
    {
        return $this->belongsTo(MrpProductionProcess::class);
    }

    public function planningProduction()
    {
        return $this->belongsTo(MrpPlanningProduction::class, 'planning_production_id');
    }
}
