<?php

namespace App\Models\Oee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OeeAlarmList extends Model
{
    use HasFactory;

    protected $table = 'oee_alarm_list';

    public function alarmMaster()
    {
        return $this->belongsTo(OeeAlarmsMaster::class, 'alarm_master_id');
    }
}
