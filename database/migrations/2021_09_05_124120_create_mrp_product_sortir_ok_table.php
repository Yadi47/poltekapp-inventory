<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpProductSortirOkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_product_sortir_ok', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('qty_ok')->nullable();
            $table->date('date')->nullable();
            $table->bigInteger("product_id")->unsigned()->nullable();
            $table->bigInteger("employee_id")->unsigned()->nullable();
            $table->text('description')->nullable();

            $table->foreign("product_id")->references("id")->on("mrp_products");
            $table->foreign("employee_id")->references("id")->on("mrp_employees");
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
        Schema::dropIfExists('mrp_product_sortir_ok');
    }
}
