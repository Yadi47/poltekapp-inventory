<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShiftIdToMrpInventoryMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_inventory_materials', function (Blueprint $table) {
            $table->bigInteger("shift_id")->unsigned()->nullable();
            
            $table->foreign("shift_id")->references("id")->on("mrp_shifts");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_inventory_materials', function (Blueprint $table) {
            //
        });
    }
}
