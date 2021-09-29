<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpDeliveryShipment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function vehicle()
    {
        return $this->belongsTo(MrpVehicle::class);
    }

    public function customer()
    {
        return $this->belongsTo(MrpCustomer::class);
    }

    public function deliveryPlanning()
    {
        return $this->belongsTo(MrpDeliveryPlanning::class);
    }

    public function inventoryShipment()
    {
        return $this->belongsTo(MrpInventoryShipment::class);
    }
}
