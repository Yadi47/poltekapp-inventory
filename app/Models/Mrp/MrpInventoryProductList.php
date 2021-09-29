<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpInventoryProductList extends Model
{
    use HasFactory;

    protected $table = 'mrp_inventory_product_list';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(MrpProduct::class);
    }

    public function MrpInventoryProductIncomings()
    {
        return $this->hasMany(MrpInventoryProductIncoming::class);
    }

    public function MrpInventoryProductOut()
    {
        return $this->hasMany(MrpInventoryProductOut::class);
    }

    public function productSortir()
    {
        return $this->hasMany(MrpProductSortir::class);
    }

    public function productSortirOK()
    {
        return $this->hasMany(MrpProductSortirOK::class);
    }

    public function productSortirNG()
    {
        return $this->hasMany(MrpProductSortirNG::class);
    }

    public function deliveryPlanning()
    {
        return $this->hasMany(MrpDeliveryPlanning::class);
    }

    public function inventoryShipment()
    {
        return $this->hasMany(MrpInventoryShipment::class);
    }
    public function inventoryPlanning()
    {
        return $this->hasMany(MrpInventoryPlanning::class);
    }

    public function totalStock() {
        $data = MrpInventoryProductList::where('id' ,$this->id)->first();
        if ($data->stock == 0 || $data->total_target_day == 0) {
            return 0;
        }
        return floor($data->stock / $data->total_target_day);
    }

    public function stockActual()
    {
        $dataIncoming = MrpInventoryProductIncoming::where('inventory_product_list_id', $this->id)->sum('product_incoming');
        return $dataIncoming + $this->stock;
    } 

    public function deliveryPlan()
    {
        return $this->hasMany(MrpDeliveryPlanning::class);
    }

    
}
