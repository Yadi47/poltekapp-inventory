<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpMaterial extends Model
{
    use HasFactory;

    protected $table = 'mrp_materials';

    protected $guarded = [''];

    public function supplier()
    {
        return $this->belongsTo(MrpSupplier::class);
    }

    public function bomMaterial()
    {
        return $this->belongsTo(MrpBomMaterial::class);
    }

    public function boms()
    {
        return $this->belongsToMany(MrpBom::class,'mrp_bom_materials','material_id','bom_id');
    }

    public function units()
    {
        return $this->belongsToMany(MrpUnit::class,'mrp_bom_materials','material_id','unit_id');
    }

    public function unit()
    {
        return $this->belongsTo(MrpUnit::class);
    }

    public function inventoryMaterials()
    {
        return $this->hasMany(MrpInventoryMaterial::class);
    }

    public function inventoryMaterialLists()
    {
        return $this->hasMany(MrpInventoryMaterialList::class);
    }

    public function inventoryMaterialIncomings()
    {
        return $this->hasMany(MrpInventoryMaterialIncoming::class);
    }
    
    public function report_boms(){
        return $this->hasMany(MrpReportBom::class);
    }

    public function bom(){
        return $this->hasMany(MrpBom::class);
    }

    // public function materialSortir()
    // {
    //     return $this->belongsTo(MrpMaterialSortir::class);
    // }

    // public function materialSortirOK()
    // {
    //     return $this->belongsTo(MrpMaterialSortirOk::class);
    // }

}
