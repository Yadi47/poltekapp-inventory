<?php

namespace App\Models\mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpInventoryPlanning extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function inventoryProductList()
    {
        return $this->belongsTo(MrpInventoryProductList::class, 'inventory_product_list_id');
    }

    public function unit()
    {
        return $this->belongsTo(MrpUnit::class);
    }
}
