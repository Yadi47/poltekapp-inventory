<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpMaterialSortirOK extends Model
{
    use HasFactory;

    protected $table = 'mrp_material_sortir_ok';

    protected $guarded = [''];

    public function inventoryMaterialList()
    {
        return $this->belongsTo(MrpInventoryMaterialList::class, 'inventory_material_list_id');
        
    }

    public function employee()
    {
        return $this->belongsTo(MrpEmployee::class);
        
    }

    public function materialSortir()
    {
        return $this->belongsTo(MrpMaterialSortir::class);
        
    }

}
