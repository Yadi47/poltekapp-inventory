<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpSupplier extends Model
{
    use HasFactory;

    protected $table = 'mrp_suppliers';

    protected $fillable = [
        'supplier_code','supplier_name','address','phone','email','website','description',
    ];

    public function machines()
    {
        return $this->hasMany(MrpMachine::class);
    }

    public function materials()
    {
        return $this->hasMany(MrpMaterial::class);
    }
}
