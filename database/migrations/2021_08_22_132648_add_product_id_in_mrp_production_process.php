<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdInMrpProductionProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_production_process', function (Blueprint $table) {
            $table->bigInteger('qty_plan')->nullable();
            $table->bigInteger("machine_id")->unsigned()->nullable();
            $table->bigInteger("planning_production_boms_id")->unsigned()->nullable();
            $table->bigInteger("planning_production_products_id")->unsigned()->nullable();

            $table->foreign("machine_id")->references("id")->on("mrp_machines");
            $table->foreign("planning_production_boms_id")->references("id")->on("mrp_planning_production_boms");
            $table->foreign("planning_production_products_id")->references("id")->on("mrp_planning_production_products");
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
            $table->dropColumn('planning_production_boms_id');
            $table->dropColumn('planning_production_products_id');
            $table->dropColumn('qty_plan');
            $table->dropColumn('machine_id');
            
        });
    }
}
