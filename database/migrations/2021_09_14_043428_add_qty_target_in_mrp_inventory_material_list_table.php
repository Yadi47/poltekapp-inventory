<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQtyTargetInMrpInventoryMaterialListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_inventory_material_list', function (Blueprint $table) {
            $table->bigInteger('qty_target')->nullable();
            $table->bigInteger('target_day')->nullable();
            $table->bigInteger('total_target_day')->nullable();
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
            //
        });
    }
}
