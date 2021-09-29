<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpPlanningProductionCustomer extends Model
{
    use HasFactory;

    protected $table = 'mrp_planning_production_process';

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(MrpCustomer::class, 'customer_id');
    }

    public function planning()
    {
        return $this->belongsTo(MrpPlanningProduction::class);
    }
}
