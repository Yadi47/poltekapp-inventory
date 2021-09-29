<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpInventoryShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_inventory_shipments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inventory_product_list_id')->unsigned()->nullable();
            $table->foreign('inventory_product_list_id')->references('id')->on('mrp_inventory_product_list')->onDelete('set null');
            $table->integer('quantity');
            $table->bigInteger('unit_id')->unsigned()->nullable();
            $table->foreign('unit_id')->references('id')->on('mrp_units')->onDelete('set null');
            $table->string('po_code')->unique();
            $table->bigInteger('delivery_shipment_id')->unsigned()->nullable();
            $table->foreign('delivery_shipment_id')->references('id')->on('mrp_delivery_shipments')->onDelete('set null');
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
        Schema::dropIfExists('mrp_inventory_shipments');
    }
}
