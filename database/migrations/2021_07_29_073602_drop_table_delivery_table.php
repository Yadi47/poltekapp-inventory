<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTableDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('mrp_shipment_catches');
        Schema::dropIfExists('mrp_planning_catches');
        Schema::dropIfExists('mrp_delivery_plannings');
        Schema::dropIfExists('mrp_delivery_shipments');
        // Schema::drop('mrp_shipment_catches');
        // Schema::drop('mrp_planning_catches');
        // Schema::drop('mrp_delivery_plannings');
        // Schema::drop('mrp_delivery_shipments');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
