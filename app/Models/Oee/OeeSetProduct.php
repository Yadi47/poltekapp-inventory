<?php

namespace App\Models\Oee;

use App\Models\Mrp\MrpProduction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OeeSetProduct extends Model
{
    use HasFactory;
    protected $table = 'oee_set_products';
    
    protected $guarded = [];
    public function production()
    {
        return $this->belongsTo(MrpProduction::class);
    }

}
