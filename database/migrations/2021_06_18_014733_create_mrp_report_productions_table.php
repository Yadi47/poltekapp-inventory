<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpReportProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_report_productions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_name');
            $table->bigInteger("machine_id")->unsigned()->nullable();
            $table->bigInteger("shift_id")->unsigned()->nullable();
            $table->bigInteger("production_id")->unsigned()->nullable();
            $table->bigInteger("planning_id")->unsigned()->nullable();

            $table->foreign("machine_id")->references("id")->on("mrp_machines");
            $table->foreign("shift_id")->references("id")->on("mrp_shifts");
            $table->foreign("production_id")->references("id")->on("mrp_productions");
            $table->foreign("planning_id")->references("id")->on("mrp_planning_productions");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mrp_report_productions');
    }
}
