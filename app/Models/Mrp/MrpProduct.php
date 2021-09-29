<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpProduct extends Model
{
    use HasFactory;

    protected $table = 'mrp_products';

    // protected $fillable = ['product_code','product_name','part_name','dim_long','dim_width','dim_height','dim_weight','color','price','description','unit_id','customer_id','part_number'];

    protected $guarded = [''];

    public function customer()
    {
        return $this->belongsTo(MrpCustomer::class);
    }

    public function bom()
    {
        return $this->belongsTo(MrpBom::class, 'bom_id');
    }

    public function unit()
    {
        return $this->belongsTo(MrpUnit::class);
    }   

    public function production()
    {
        return $this->belongsTo(MrpProduction::class);
    }   


    public function inventoryProducts()
    {
        return $this->hasMany(MrpInventoryProduct::class);
    }

    public function machine()
    {
        return $this->hasMany(MrpMachine::class, 'product_id');
    }

    public function planningProducts()
    {
        return $this->hasMany(MrpMachine::class, 'product_id');
    }
    
    public function productionProcessMachineProduct()
    {
        return $this->hasMany(MrpProductionProcessMachineProduct::class);
    }

    // public function inventoryProductList()
    // {
    //     return $this->belongsTo(MrpInventoryProductList::class);
    // }

    public function planningProduct()
    {
        return $this->hasMany(MrpPlanningProductionProduct::class, 'product_id');
    }

    public function forecast()
    {
        return $this->hasMany(MrpForecast::class);
    }
    
    public function inventoryProductList()
    {
        return $this->hasMany(MrpInventoryProductList::class);
    }

    public function productSortir()
    {
        return $this->belongsTo(MrpProductSortir::class);
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