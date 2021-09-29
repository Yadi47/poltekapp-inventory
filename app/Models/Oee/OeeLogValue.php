<?php

namespace App\Models\Oee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OeeLogValue extends Model
{
    use HasFactory;
    private $paam = '';
    protected $table = 'oee_plc_values';
   

   
}
