<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpWipProcess extends Model
{
    use HasFactory;
    protected $table = 'mrp_wip_process';
    protected $guarded = [];

    public function ProcessMachineProduct()
    {
        return $this->belongsTo(MrpProductionProcessMachineProduct::class,'mrp_production_process_machine_product_id');
    }

    public function shift(){
        return $this->belongsTo(MrpShift::class,'shift_id');
    }

    
    
}
