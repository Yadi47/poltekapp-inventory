<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpProduction extends Model
{

    use HasFactory;

    protected $table = 'mrp_productions';

    // protected $fillable = [
    //     'bom_id', 'shift_id', 'production_code', 'production_name', 'plan_code', 'plan_name', 'qty_plan', 'qty_entry', 'qty_reject', 'qty_good', 'date_start', 'date_finish', 'problem_id', 'counter_measure_id', 'proces_id',
    //     'bom_id','shift_id','production_code','production_name','planning_id','qty_plan','qty_entry','qty_reject','qty_good','date_start','date_finish','problem_id','counter_measure_id','proces_id',
    // ];
    protected $guarded = [''];


    public function shift()
    {
        return $this->belongsTo(MrpShift::class);
    }

    public function bom()
    {
        return $this->belongsTo(MrpBom::class);
    }

    public function problem()
    {
        return $this->belongsTo(MrpProblem::class);
    }


    public function machine()
    {
        return $this->belongsTo(MrpMachine::class);
    }

    public function process()
    {
        return $this->belongsToMany(MrpProcess::class, 'mrp_production_process', 'production_id', 'process_id')->withPivot(['qty_entry','qty_good','qty_reject']);
    }

    public function product()
    {
        return $this->belongsTo(MrpProduct::class, 'product_id');
    }

    public function counter_measure()
    {
        return $this->belongsTo(MrpCounter_measure::class);
    }

    public function planning()
    {
        return $this->belongsTo(MrpPlanningProduction::class);
    }

    public function productionProcessMachineProduct()
    {
        return $this->hasMany(MrpProductionProcessMachineProduct::class,'production_id');
    }

    public function productionProcess()
    {
        return $this->belongsTo(MrpProductionProcess::class);
    }


    // public function delivery_plannings()
    // {
    //     return $this->hasMany(MrpDeliveryPlanning::class);
    // }

    public function report_wips()
    {
        return $this->hasMany(MrpReportWip::class);
    }

    

    // public function products()
    // {
    //     return $this->hasMany(MrpProduct::class);
    // }

    public function delivery_shipments()
    {
        return $this->belongsTo(MrpDeliveryShipment::class);
    }

    // public function shipmentCatch()
    // {
    //     return $this->belongsTo(MrpShipmentCatch::class);
    // }

    public function inventoryProductList()
    {
        return $this->belongsTo(MrpInventoryProductList::class, 'id', 'product_id');
    }


}
