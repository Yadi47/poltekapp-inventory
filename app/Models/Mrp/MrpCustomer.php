<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpCustomer extends Model
{
    use HasFactory;

    protected $table = 'mrp_customers';

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(MrpProducts::class);
    }

    public function delivery_plannings()
    {
        return $this->hasMany(MrpDeliveryPlanning::class);
    }

    public function forecast()
    {
        return $this->hasMany(MrpForecast::class);
    }

    public function customerDocs()
    {
        return $this->hasMany(MrpCustomerDocsCd::class, 'customer_id');
    }
}
