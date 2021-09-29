<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpEmployeePlaces extends Model
{
    use HasFactory;

    protected $table = 'mrp_employee_places';

    protected $guarded = [];

    public function places()
    {
        return $this->belongsTo(MrpEmployee::class);
    }
    
}
