<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropRelationMaterialIdInMrpMaterialSortirOk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_material_sortir_ok', function (Blueprint $table) {
            $table->dropColumn('material_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_material_sortir_ok', function (Blueprint $table) {
            //
        });
    }
}
