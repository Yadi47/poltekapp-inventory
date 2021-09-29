<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpPlanningProductionCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_planning_production_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("planning_production_id")->unsigned()->nullable();
            $table->bigInteger("customer_id")->unsigned()->nullable();
            
            $table->foreign("planning_production_id")->references("id")->on("mrp_planning_productions");
            $table->foreign("customer_id")->references("id")->on("mrp_customers");
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
        Schema::dropIfExists('mrp_planning_production_customers');
    }
}
