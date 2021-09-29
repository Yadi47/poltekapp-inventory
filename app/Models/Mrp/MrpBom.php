<?php



namespace App\Models\Mrp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MrpBom extends Model
{
    use HasFactory;

    protected $table = 'mrp_boms';

    protected $guarded = []; 

    public function materials()
    {
        return $this->belongsToMany(MrpInventoryMaterialList::class,'mrp_bom_materials','bom_id','material_id')->withPivot('qty_material');
    }

    public function bomMaterial(){
        // $data = \App\Mrp\Models\MrpBomMaterial::find($this->id); 
        return $this->belongsToMany('MrpMaterial')->withPivot();
    }

    public function materialUnits(){
    //Mengambil data  pivot unit
        $data = collect(DB::select('select * from mrp_bom_materials where bom_id = :bom_id', ['bom_id' => $this->id]))->map(function ($value) {
            $data['inventory_material'] = MrpInventoryMaterialList::findOrFail($value->material_id)->material->material_name;
            $data['unit'] = MrpUnit::find($value->unit_id)->unit_name ?? 'N/A';
            $data['qty_material'] = $value->qty_material ?? '';
            return $data;
        });
        return $data;
    }

    public function units()
    {
        return $this->belongsToMany(MrpUnit::class,'mrp_bom_materials','bom_id','unit_id');
    }

    public function report_boms(){
        return $this->hasMany(MrpReportBom::class);
    }


    public function mrpPlanningProductionProcess()
    {
        return $this->hasMany(MrpPlanningProductionProcess::class);
    }

    public function product()
    {
        return $this->belongsTo(MrpProduct::class);
    }
    
    public function products()
    {
        return $this->hasMany(MrpProduct::class,'bom_id');
    }
    //    public function unit()
    //    {
    //        return $this->belongsTo(MrpUnit::class,'unit_id');
    //    }
       
    //    public function bom()
    //    {
    //        return $this->belongsTo(MrpBom::class,'bom_id');
    //    }
   
    //    public function material()
    //    {
    //        return $this->belongsTo(MrpMaterial::class,'material_id');
    //    }





// namespace App\Models\Mrp;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;

// class MrpBom extends Model
// {
//     use HasFactory;

//     protected $table = 'mrp_boms';

//     protected $guarded = []; 

//     public function materials()
//     {
//         return $this->belongsToMany(MrpInventoryMaterialList::class,'mrp_bom_materials','bom_id','material_id')->withPivot('qty_material');
//     }

//     public function material(){
//         return $this->belongsTo(MrpMaterial::class,'bom_id' );
//     }

//     public function bomMaterial(){
//         // $data = \App\Mrp\Models\MrpBomMaterial::find($this->id); 
//         return $this->belongsToMany('MrpMaterial')->withPivot();
//     }

//     public function materialUnits(){
//     //Mengambil data  pivot unit
//         $data = collect(DB::select('select * from mrp_bom_materials where bom_id = :bom_id', ['bom_id' => $this->id]))->map(function ($value) {
//             $data['inventory_material'] = MrpInventoryMaterialList::findOrFail($value->material_id)->material->material_name;
//             $data['unit'] = MrpUnit::find($value->unit_id)->unit_name ?? 'N/A';
//             $data['qty_material'] = $value->qty_material ?? '';
//             return $data;
//         });
//         return $data;
//     }
    

//     public function units()
//     {
//         return $this->belongsToMany(MrpUnit::class,'mrp_bom_materials','bom_id','unit_id');
//     }

//     public function report_boms(){
//         return $this->hasMany(MrpReportBom::class);
//     }


//     public function mrpPlanningProductionProcess()
//     {
//         return $this->hasMany(MrpPlanningProductionProcess::class);
//     }
}