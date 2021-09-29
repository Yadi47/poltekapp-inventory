<?php

namespace App\Models\Oee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OeeAlarms extends Model
{
    use HasFactory;

    protected $table = 'alarms';
    protected $fillable = [
        'alarm_master_id',
        'alarm_detail_id',
    ];

    public function alarmMaster()
    {
        return $this->belongsTo(OeeAlarmsMaster::class, 'alarm_master_id');
    }

    public function alarmDetail()
    {
        return $this->belongsTo(OeeAlarmDetail::class, 'alarm_detail_id');
    }
}
