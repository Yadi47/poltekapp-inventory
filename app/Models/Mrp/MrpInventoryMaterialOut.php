<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpInventoryMaterialOut extends Model
{
    use HasFactory;

    protected $table = 'mrp_inventory_material_out';

    protected $guarded = [];

    public function material()
    {  
        return $this->belongsTo(MrpMaterial::class);
    }
    public function machine()
    {
        return $this->belongsTo(MrpMachine::class);
    }

    public function employee()
    {
        return $this->belongsTo(MrpEmployee::class);
    }

    public function inventoryMaterialList()
    {
        return $this->belongsTo(MrpInventoryMaterialList::class, 'inventory_material_list_id');
    }
}
