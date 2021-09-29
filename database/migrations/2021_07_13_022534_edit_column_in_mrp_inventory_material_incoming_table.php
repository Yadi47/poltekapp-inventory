<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnInMrpInventoryMaterialIncomingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_inventory_material_incoming', function (Blueprint $table) {
            $table->dropForeign(['material_id']);

            $table->foreign('material_id')
                ->references('id')
                ->on('mrp_inventory_material_list')
                ->onDelete('cascade');
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
