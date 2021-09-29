<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpPlanningProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_planning_productions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plan_code')->unique();
            $table->string('plan_name');
            $table->integer('plan_qty');
            $table->string('start_date');
            $table->string('target_date');
            $table->string('finish_date');
            $table->text('description')->nullable();
            $table->bigInteger("product_id")->unsigned()->nullable();
            $table->bigInteger("bom_id")->unsigned()->nullable();
            $table->bigInteger("customer_id")->unsigned()->nullable();
            $table->bigInteger("unit_id")->unsigned()->nullable();

            $table->foreign("product_id")->references("id")->on("mrp_products");
            $table->foreign("bom_id")->references("id")->on("mrp_boms");
            $table->foreign("customer_id")->references("id")->on("mrp_customers");
            $table->foreign("unit_id")->references("id")->on("mrp_units");

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
        Schema::dropIfExists('mrp_planning_productions');
    }
}
