<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOeeSetProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oee_set_products', function (Blueprint $table) {
            $table->id();
            // --- FOREIGN KEY
            $table->bigInteger("product_id")->unsigned()->nullable();
            $table->bigInteger("user_id")->unsigned()->nullable();
            $table->bigInteger("shift_id")->unsigned()->nullable();
            // --- DETAIL PRODUCT
            $table->string('product_code');
            $table->string('product_name');
            $table->string('part_name');
            $table->float('dim_long');
            $table->float('dim_width');
            $table->float('dim_height');
            $table->float('dim_weight');
            $table->string('color')->nullable();
            $table->bigInteger('price');
            $table->text('description')->nullable();
            $table->string("unit")->nullable();
            $table->string("customer")->nullable();

            $table->string("shift_code")->nullable();
            $table->string("shift_name")->nullable();
            $table->string("time_from")->nullable();
            $table->string("time_to")->nullable();
            $table->string("running_operation")->nullable();
            $table->string("total_time")->nullable();

            // --- RELATION
            $table->foreign("product_id")->references("id")->on("mrp_products");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("shift_id")->references("id")->on("mrp_shifts");

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
        Schema::dropIfExists('oee_set_products');
    }
}
