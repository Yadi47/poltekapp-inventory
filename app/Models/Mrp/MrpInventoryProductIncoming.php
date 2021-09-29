<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpInventoryProductIncoming extends Model
{
    use HasFactory;

    protected $table = 'mrp_inventory_product_incoming';

    protected $guarded = [];

    // public function product()
    // {
    //     return $this->belongsTo(MrpProduct::class);
    // }

    public function inventoryProductList()
    {
        return $this->belongsTo(MrpInventoryProductList::class, 'inventory_product_list_id');
    }
    // public function productions()
    // {
    //     return $this->belongsTo(MrpProduction::class);
    // }

    public function employee()
    {
        return $this->belongsTo(MrpEmployee::class);
    }
}
