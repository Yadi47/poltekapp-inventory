<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpShift extends Model
{
    use HasFactory;

    protected $table = 'mrp_shifts';

    protected $fillable = [
        'shift_code','shift_name','time_from','time_to','total_time','running_operation','status','description','over_night'
    ];

    public function employees()
    {
        return $this->hasMany(MrpEmployee::class);
    }
    public function inventory_material()
    {
        return $this->belongsTo(MrpInventoryMaterial::class);
    }
    
    public function report_wips()
    {
        return $this->hasMany(MrpReportWip::class);
    }
}
