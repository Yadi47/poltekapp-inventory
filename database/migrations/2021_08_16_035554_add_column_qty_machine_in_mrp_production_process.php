<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnQtyMachineInMrpProductionProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_production_process', function (Blueprint $table) {
            $table->bigInteger('qty_receive_oee')->nullable();
            $table->bigInteger('qty_reject_oee')->nullable();
            $table->bigInteger('qty_good_oee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_production_process', function (Blueprint $table) {
            //
        });
    }
}
