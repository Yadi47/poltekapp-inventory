<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpForecast extends Model
{
    use HasFactory;

    protected $table = 'mrp_forecasts';

    protected $guarded = [''];

    public function customer()
    {
        return $this->belongsTo(MrpCustomer::class);
    }

    public function product()
    {
        return $this->belongsTo(MrpProduct::class);
    }

    public function customerDocs()
    {
        return $this->belongsTo(MrpCustomerDocsCd::class, 'customer_id');
    }
}
