<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditTypeDataTargetDefectRateInMrpProductions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_productions', function (Blueprint $table) {
            $table->float('target_defect_rate')->change();
            $table->float('target_effeciency')->change();
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_productions', function (Blueprint $table) {
            //
        });
    }
}
