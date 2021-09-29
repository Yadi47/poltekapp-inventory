<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQtySortirOkNgInMrpMaterialSortirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_material_sortir', function (Blueprint $table) {
            $table->bigInteger('qty_ok')->nullable();
            $table->bigInteger('qty_ng')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_material_sortir', function (Blueprint $table) {
            //
        });
    }
}
