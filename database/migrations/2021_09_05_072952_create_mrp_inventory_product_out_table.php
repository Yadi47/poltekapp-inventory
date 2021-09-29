<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpInventoryProductOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_inventory_product_out', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_outgoing');
            $table->bigInteger('current_stock')->nullable();
            $table->bigInteger("employee_id")->unsigned()->nullable();
            $table->bigInteger("inventory_product_list_id")->unsigned()->nullable();
            $table->bigInteger("delivery_shipment_id")->unsigned()->nullable();
            $table->text('description')->nullable();

            $table->foreign("employee_id")->references("id")->on("mrp_employees");
            $table->foreign("inventory_product_list_id")->references("id")->on("mrp_inventory_product_list");
            $table->foreign("delivery_shipment_id")->references("id")->on("mrp_delivery_shipments");
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
        Schema::dropIfExists('mrp_inventory_product_out');
    }
}
