<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpInventoryMaterialIncoming extends Model
{
    use HasFactory;

    protected $table = 'mrp_inventory_material_incoming';

    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo(MrpMaterial::class);
    }

    public function employee()
    {
        return $this->belongsTo(MrpEmployee::class);
    }

    public function inventoryMaterialList()
    {
        return $this->belongsTo(MrpInventoryMaterialList::class, 'material_id');
    }

    public function inventoryMaterialIncoming()
    {
        return $this->belongsToMany(MrpInventoryMaterialOut::class);
    }
}
