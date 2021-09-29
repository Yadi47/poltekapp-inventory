<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpInventoryMaterial extends Model
{
    use HasFactory;

    protected $table = 'mrp_inventory_materials';

    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo(MrpMaterial::class);
    }
    public function shift()
    {
        return $this->belongsTo(MrpShift::class);
    }
    public function employee()
    {
        return $this->belongsTo(MrpEmployee::class);
    }

    

    
}
