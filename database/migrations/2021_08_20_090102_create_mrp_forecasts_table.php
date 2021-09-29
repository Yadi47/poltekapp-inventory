<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_forecasts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dock_cd')->unique();
            $table->string('qty_forecast');
            $table->bigInteger("product_id")->unsigned()->nullable();
            $table->bigInteger("customer_id")->unsigned()->nullable();

            $table->foreign("product_id")->references("id")->on("mrp_products");
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
        Schema::dropIfExists('mrp_forecasts');
    }
}
