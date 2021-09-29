<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpProductionProcess extends Model
{
    use HasFactory;

    protected $table = 'mrp_production_process';

    protected $guarded = [];

    // public function process(){
    //     return $this->belongsTo(MrpProcess::class);
    // }

    public function planningProcess(){
        return $this->belongsTo(MrpPlanningProductionProcess::class, 'planning_production_process_id');
    }
     
    public function boms(){
        return $this->belongsTo(MrpPlanningProductionBom::class);
    }

    public function planningProductionProduct(){
        return $this->belongsTo(MrpPlanningProductionProduct::class);
    }
    
    public function machine(){
        return $this->belongsTo(MrpMachine::class, 'machine_id');
    }

    public function production(){
        return $this->belongsTo(MrpProduction::class, 'production_id');
    }
    
    public function inventoryProduct(){
        return $this->belongsTo(MrpInventoryProductList::class);
    }

}
