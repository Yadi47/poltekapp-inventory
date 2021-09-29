<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpInventoryProductListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_inventory_product_list', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->bigInteger('stock');
            $table->bigInteger("product_id")->unsigned()->nullable();
            $table->text('description')->nullable();

            $table->foreign("product_id")->references("id")->on("mrp_products");
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
        Schema::dropIfExists('mrp_inventory_product_list');
    }
}
