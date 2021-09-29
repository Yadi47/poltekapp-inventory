<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpDeliveryShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_delivery_shipments', function (Blueprint $table) {
            $table->id();
            $table->string('dn_code')->unique();
            $table->date('delivery_date');
            $table->bigInteger('vehicle_id')->unsigned()->nullable();
            $table->foreign('vehicle_id')->references('id')->on('mrp_vehicles')->onDelete('set null');
            $table->bigInteger("customer_id")->unsigned()->nullable();
            $table->foreign("customer_id")->references("id")->on("mrp_customers")->onDelete('set null');
            $table->bigInteger("delivery_planning_id")->unsigned()->nullable();
            $table->foreign("delivery_planning_id")->references("id")->on("mrp_delivery_plannings")->onDelete('set null');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('mrp_delivery_shipments');
    }
}
