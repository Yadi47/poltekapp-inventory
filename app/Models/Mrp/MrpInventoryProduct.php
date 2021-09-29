<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpInventoryProduct extends Model
{
    use HasFactory;

    protected $table = 'mrp_inventory_products';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(MrpProduct::class);
    }
}
