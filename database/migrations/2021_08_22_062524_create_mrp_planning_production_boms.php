<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpPlanningProductionBoms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_planning_production_boms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("planning_production_id")->unsigned()->nullable();
            $table->bigInteger("bom_id")->unsigned()->nullable();

            $table->foreign("planning_production_id")->references("id")->on("mrp_planning_productions");
            $table->foreign("bom_id")->references("id")->on("mrp_boms");
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
        Schema::dropIfExists('mrp_planning_production_boms');

    }
}
