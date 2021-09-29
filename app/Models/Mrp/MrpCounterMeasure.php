<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpCounterMeasure extends Model
{
    use HasFactory;

    protected $table = 'mrp_counter_measures';

    // protected $fillable = [
    //     'cm_code','cm_name','description',
    // ];

    protected $guarded = [''];

    public function problem()
    {
        return $this->belongsTo(MrpProblem::class);
    }
}
