<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductionIdToMrpInventoryMaterialIncomingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_inventory_material_incoming', function (Blueprint $table) {
            $table->bigInteger("production_id")->unsigned()->nullable();

            $table->foreign("production_id")->references("id")->on("mrp_productions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_inventory_material_incoming', function (Blueprint $table) {
            //
        });
    }
}
