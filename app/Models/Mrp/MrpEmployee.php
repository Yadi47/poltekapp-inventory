<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpEmployee extends Model
{
    use HasFactory;

    protected $table = 'mrp_employees';

    protected $fillable = [
        'nik','employee_name','departement','section','title','grade','place_id','shift_id','description',
    ];

    public function places()
    {
        return $this->belongsToMany(MrpPlace::class, 'mrp_employee_places', 'employee_id', 'place_id');
    }

    public function shift()
    {
        return $this->belongsTo(MrpShift::class);
    }
    public function inventoryMaterial()
    {
        return $this->belongsTo(MrpInventoryMaterial::class);
    }
    
    public function inventoryMaterialIncoming()
    {
        return $this->belongsTo(MrpInventoryMaterialIncoming::class);
    }
    
    public function inventoryProductIncoming()
    {
        return $this->belongsTo(MrpInventoryProductIncoming::class);
    }

    

    public function materialSortir()
    {
        return $this->belongsTo(MrpMaterialSortir::class);
    }

    public function productSortir()
    {
        return $this->belongsTo(MrpProductSortir::class);
    }

    public function materialSortirOK()
    {
        return $this->belongsTo(MrpMaterialSortirOK::class);
    }

    public function productSortirOK()
    {
        return $this->belongsTo(MrpProductSortirOK::class);
    }
    public function productSortirNG()
    {
        return $this->belongsTo(MrpProductSortirNG::class);
    }

}
