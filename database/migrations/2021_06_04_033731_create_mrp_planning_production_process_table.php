<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpPlanningProductionProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_planning_production_process', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("planning_production_id")->unsigned()->nullable();
            $table->bigInteger("process_id")->unsigned()->nullable();

            $table->foreign("planning_production_id")->references("id")->on("mrp_planning_productions");
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
        Schema::dropIfExists('mrp_planning_production_process');
    }
}
