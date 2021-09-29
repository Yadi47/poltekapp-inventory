<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTargetProductPerformanceAndCycleTimeToOeeMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oee_machines', function (Blueprint $table) {
            $table->float('target_defect_rate')->nullable();
            $table->float('target_effeciency')->nullable();
            $table->float('cycle_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oee_machines', function (Blueprint $table) {
            //
        });
    }
}
