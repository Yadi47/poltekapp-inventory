<?php

namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MrpReportBom extends Model
{
    use HasFactory;
    
    protected $table = 'mrp_report_boms';

    protected $guarded = [''];

    public function boms(){
        return $this->belongsTo(MrpBom::class);
    }
    
    public function units(){
        return $this->belongsTo(MrpUnit::class);
    }

    public function materials(){
        return $this->belongsTo(MrpMaterial::class);
    }

    public function bom_materials(){
        return $this->belongsTo(MrpBomMaterial::class );
    }
}
