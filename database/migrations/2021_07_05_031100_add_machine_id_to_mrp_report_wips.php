<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMachineIdToMrpReportWips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_report_wips', function (Blueprint $table) {
            $table->bigInteger("machine_id")->unsigned()->nullable();

            $table->foreign("machine_id")->references("id")->on("mrp_machines");
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_report_wips', function (Blueprint $table) {
            //
        });
    }
}
