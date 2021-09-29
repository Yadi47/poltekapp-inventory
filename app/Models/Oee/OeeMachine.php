<?php

namespace App\Models\Oee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OeeMachine extends Model
{
    use HasFactory;
    protected $table = 'oee_machines';

    protected $guarded = []; 

    public function statusIndex(){
        return $this->status === 1 ? 'Active' : "Inactive";
    }

    public function oeeAlarmMaster()
    {
        return $this->hasMany(OeeAlarmsMaster::class,'machine_id');
    }

    public function machineStation()
    {
        return $this->belongsTo(OeeMachineStation::class);
    }
}
