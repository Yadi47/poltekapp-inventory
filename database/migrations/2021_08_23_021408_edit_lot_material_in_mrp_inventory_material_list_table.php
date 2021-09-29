<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditLotMaterialInMrpInventoryMaterialListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_inventory_material_list', function (Blueprint $table) {
            DB::statement('ALTER TABLE mrp_inventory_material_list ALTER COLUMN 
                  lot_material TYPE  DATE USING (lot_material::date)');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_inventory_material_list', function (Blueprint $table) {
            DB::statement('ALTER TABLE mrp_inventory_material_list ALTER COLUMN 
                  lot_material TYPE  DATE USING (lot_material::date)');
        });
    }
}
