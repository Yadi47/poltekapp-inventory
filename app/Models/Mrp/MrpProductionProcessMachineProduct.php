<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpProductionProcessMachineProduct extends Model
{
    use HasFactory;
    protected $table = 'mrp_production_process_machine_product';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(MrpProduct::class);
    }
    public function process()
    {
        return $this->belongsTo(MrpProcess::class);
    }
    public function machine()
    {
        return $this->belongsTo(MrpMachine::class);
    }

    public function ProductInWip(){
        return $this->hasMany(MrpWipProcess::class,'mrp_production_process_machine_product_id');
    }

    public function production(){
        return $this->belongsTo(MrpProduction::class);

    }

    public function Wip()
    {
        return $this->belongsTo(MrpWipProcess::class);
    }

}
