<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpUnit extends Model
{
    use HasFactory;

    protected $table = 'mrp_units';

    protected $fillable = [
        'unit_code', 'unit_name', 'description',
    ];

    public function machines()
    {
        return $this->hasMany(MrpMachine::class);
    }

    public function products()
    {
        return $this->hasMany(MrpProducts::class);
    }

    public function delivery_plannings()
    {
        return $this->hasMany(MrpDeliveryPlanning::class);
    }

    public function materials()
    {
        return $this->belongsToMany(MrpMaterial::class, 'mrp_bom_materials', 'unit_id', 'material_id');
    }

    public function boms()
    {
        return $this->belongsToMany(MrpBom::class, 'mrp_bom_materials', 'unit_id', 'bom_id');
    }

    public function deliveryShipments()
    {
        return $this->hasMany(MrpShipment::class);
    }

    public function shipmentCatch()
    {
        return $this->hasMany(MrpShipmentCatch::class);
    }

    public function planningCatch()
    {
        return $this->hasMany(MrpPlanningCatch::class);
    }

    public function report_boms(){
        return $this->hasMany(MrpReportBom::class);
    }
}
