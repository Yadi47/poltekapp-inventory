<?php

namespace App\Models\Oee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OeeAlarmDetail extends Model
{
    use HasFactory;

    protected $table = 'alarm_detail';
    protected $fillable = [
        'id',
        'index_array',
        'text',
    ];
    public function alarmMasters()
    {
        return $this->belongsToMany(OeeAlarmsMaster::class);
    }
}
