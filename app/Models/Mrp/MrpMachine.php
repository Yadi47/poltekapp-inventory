<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpMachine extends Model
{
    use HasFactory;

    protected $table = 'mrp_machines';

    protected $guarded = [''];


    // public function process()
    // {
    //     return $this->hasMany(MrpProcess::class);
    // }
    
    public function unit()
    {
        return $this->belongsTo(MrpUnit::class);
    }
    public function inventoryMaterialOut()
    {
        return $this->belongsTo(MrpInventoryMaterialOut::class);
    }

    public function product()
    {
        return $this->belongsTo(MrpProduct::class, 'product_id');
    }

    public function place()
    {
        return $this->belongsTo(MrpPlace::class);
    }

    public function supplier()
    {
        return $this->belongsTo(MrpSupplier::class);
    }

    public function process()
    {

        return $this->hasMany(MrpProcess::class);

        // return $this->belongsToMany(MrpProcess::class);
    }
    public function productionProcess()
    {
        return $this->belongsTo(MrpProductionProcess::class);
    }
}