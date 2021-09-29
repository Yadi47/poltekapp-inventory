<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditReferenceProcessIdInMrpProductionProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_production_process', function (Blueprint $table) {
            // $table->bigInteger("planning_production_process_id")->unsigned()->nullable();

            // $table->foreign("planning_production_process_id")->references("id")->on("mrp_planning_production_process");
            
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
