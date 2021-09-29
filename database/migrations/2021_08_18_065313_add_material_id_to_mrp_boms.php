<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaterialIdToMrpBoms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_boms', function (Blueprint $table) {
            $table->bigInteger("material_id")->unsigned()->nullable();
            $table->bigInteger("unit_id")->unsigned()->nullable();
            
            $table->foreign("material_id")->references("id")->on("mrp_materials");
            $table->foreign("unit_id")->references("id")->on("mrp_units");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_boms', function (Blueprint $table) {
            $table->dropColumn('material_id');
            $table->dropColumn('unit_id');
        });
    }
}
