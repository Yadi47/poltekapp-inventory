<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpBomMaterial extends Model
{
    use HasFactory;

    protected $table = 'mrp_bom_materials';

    protected $guarded = []; 

    public function inventoryMaterials()
    {
        return $this->belongsToMany(MrpInventoryMaterialList::class,'mrp_bom_materials','material_id');
    }

    public function units()
    {
        return $this->belongsToMany(MrpUnit::class,'mrp_bom_materials','unit_id');
    }

    public function boms()
    {
        return $this->belongsToMany(MrpBom::class,'mrp_bom_materials','bom_id');
    }


    // -------------------------------------------
    public function unit()
    {
        return $this->belongsTo(MrpUnit::class,'unit_id');
    }
    
    public function bom()
    {
        return $this->belongsTo(MrpBom::class,'bom_id');
    }

    public function material()
    {
        return $this->belongsTo(MrpMaterial::class,'material_id');
    }
    // -------------------------------------------


    public function report_boms(){
        return $this->hasMany(MrpReportBom::class);
    }

    public function getMaterial()
    {
        return $this->belongsTo(MrpInventoryMaterialList::class,'material_id','id');

    }

}
