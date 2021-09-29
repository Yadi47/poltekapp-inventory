<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProductInMrpPlanningProductionProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_planning_production_process', function (Blueprint $table) {
            $table->bigInteger("product_id")->unsigned()->nullable();
            $table->bigInteger("bom_id")->unsigned()->nullable();

            $table->foreign("product_id")->references("id")->on("mrp_products");
            $table->foreign("bom_id")->references("id")->on("mrp_boms");
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_planning_production_process', function (Blueprint $table) {
            //
        });
    }
}
