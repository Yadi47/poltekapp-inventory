<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpProcessMachine extends Model
{
    use HasFactory;

    protected $table = 'mrp_process_machines';

    protected $guarded = [];

    public function machine()
    {
        return $this->belongsTo(MrpMachine::class,'machine_id');
    }

    public function process()
    {
        return $this->belongsTo(MrpProcess::class);
    }

    
}
