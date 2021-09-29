<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpProblem extends Model
{
    use HasFactory;

    protected $table = 'mrp_problems';

    protected $fillable = [
        'problem_code','problem_name','description',
    ];

    public function problem()
    {
        return $this->hasMany(MrpProblem::class);
    }
}
