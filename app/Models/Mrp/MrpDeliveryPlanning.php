<?php

namespace App\Models\mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpDeliveryPlanning extends Model
{
    use HasFactory;

    protected $table = 'mrp_delivery_plannings';

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(MrpCustomer::class);
    }
}
