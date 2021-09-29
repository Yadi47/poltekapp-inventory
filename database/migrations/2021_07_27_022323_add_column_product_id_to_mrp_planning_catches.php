<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProductIdToMrpPlanningCatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('mrp_planning_catches', function (Blueprint $table) {
        //     $table->bigInteger("product_id")->unsigned()->nullable();

        //     $table->foreign("product_id")->references("id")->on("mrp_inventory_product_list");
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_planning_catches', function (Blueprint $table) {
            //
        });
    }
}
