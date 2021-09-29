<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpReportWipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_report_wips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("production_id")->unsigned()->nullable();
            $table->bigInteger("shift_id")->unsigned()->nullable();
            $table->bigInteger("process_id")->unsigned()->nullable();

            $table->foreign("production_id")->references("id")->on("mrp_productions");
            $table->foreign("shift_id")->references("id")->on("mrp_shifts");
            $table->foreign("process_id")->references("id")->on("mrp_process");
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
        Schema::dropIfExists('mrp_report_wips');
    }
}
