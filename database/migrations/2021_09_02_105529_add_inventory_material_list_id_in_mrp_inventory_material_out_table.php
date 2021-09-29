<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInventoryMaterialListIdInMrpInventoryMaterialOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_inventory_material_out', function (Blueprint $table) {
            $table->bigInteger("inventory_material_list_id")->unsigned()->nullable();
            $table->foreign("inventory_material_list_id")->references("id")->on("mrp_inventory_material_list");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_inventory_material_out', function (Blueprint $table) {
            
        });
    }
}
