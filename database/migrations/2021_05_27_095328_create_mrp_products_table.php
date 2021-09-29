<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_code')->unique();
            $table->string('product_name')->unique();
            $table->string('part_name');
            $table->float('dim_long');
            $table->float('dim_width');
            $table->float('dim_height');
            $table->float('dim_weight');
            $table->string('colour');
            $table->bigInteger('price');
            $table->text('description')->nullable();

            $table->bigInteger("unit_id")->unsigned()->nullable();
            $table->bigInteger("customer_id")->unsigned()->nullable();

            $table->foreign("unit_id")->references("id")->on("mrp_units");
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
        Schema::dropIfExists('mrp_products');
    }
}
