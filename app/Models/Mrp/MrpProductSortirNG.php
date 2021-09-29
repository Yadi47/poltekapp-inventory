<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpProductSortirNG extends Model
{
    use HasFactory;
    protected $table = 'mrp_product_sortir_ng';

    protected $guarded = [''];

    public function inventoryProductList()
    {
        return $this->belongsTo(MrpInventoryProductList::class, 'inventory_product_list_id');
        
    }

    public function employee()
    {
        return $this->belongsTo(MrpEmployee::class);
        
    }

}
