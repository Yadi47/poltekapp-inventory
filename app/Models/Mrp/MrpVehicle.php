<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_code', 'type', 'driver', 'description',
    ];

    public function shipments()
    {
        return $this->hasMany(MrpShipment::class);
    }
}
