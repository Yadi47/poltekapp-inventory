<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpCustomerDocsCd extends Model
{
    use HasFactory;

    protected $table = 'mrp_customer_docs';

    protected $guarded = [];

    public function customerDocs()
    {
        return $this->belongsTo(MrpCustomer::class);
    }

    public function forecast()
    {
        return $this->hasMany(MrpForecast::class);
    }
}
