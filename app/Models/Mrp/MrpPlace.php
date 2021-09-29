<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpPlace extends Model
{
    use HasFactory;

    protected $table = 'mrp_places';

    protected $fillable = [
        'place_code','place_name','description',
    ];

    public function employees()
    {
        return $this->hasMany(MrpEmployee::class);
    }

    public function machines()
    {
        return $this->hasMany(MrpMachine::class);
    }
}
