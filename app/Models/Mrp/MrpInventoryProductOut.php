<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpInventoryProductOut extends Model
{
    use HasFactory;

    protected $table = 'mrp_inventory_product_out';

    protected $guarded = [];

    public function planningCatch()
    {
        return $this->hasMany(MrpPlanningCatch::class);
    }

    public function deliveryPlanning()
    {
        return $this->hasMany(MrpDeliveryPlanning::class, 'product_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(MrpEmployee::class);
    }

    public function productList()
    {
        return $this->belongsTo(MrpInventoryProductList::class, 'inventory_product_list_id');
    }

    public function deliveryShipment()
    {
        return $this->belongsTo(MrpDeliveryShipment::class);
    }

}
