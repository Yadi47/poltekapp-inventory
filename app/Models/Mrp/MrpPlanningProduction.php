<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpPlanningProduction extends Model
{
    use HasFactory;

    protected $table = 'mrp_planning_productions';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsToMany(MrpProduct::class, 'mrp_planning_production_products', 'planning_production_id', 'product_id')->withPivot('quantity');
    }


    public function oneProduct($planId, $prodId)
    {
        return $this->belongsToMany(MrpProduct::class, 'mrp_planning_production_products', 'planning_production_id', 'product_id')->wherePivot('planning_production_id', $planId)->wherePivot('product_id',$prodId)->withPivot('quantity');
    }

    public function bom()
    {
        return $this->belongsTo(MrpBom::class);
    }

    public function process()
    {
        return $this->belongsToMany(MrpProcess::class, 'mrp_planning_production_process', 'planning_production_id', 'process_id');
    }

    public function customers()
    {
        return $this->belongsToMany(MrpCustomer::class, 'mrp_planning_production_customers', 'planning_production_id', 'customer_id');
    }

    public function unit()
    {
        return $this->belongsTo(MrpUnit::class);
    }

    public function planningProductionProduct()
    {
        return $this->hasMany(MrpPlanningProductionProduct::class, 'planning_production_id');
    }

    public function product_part()
    {
        return $this->belongsTo(MrpPlanningProductionProduct::class, 'planning_production_id');
    }

}
