<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTableInMrpInventoryProductOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_inventory_product_out', function (Blueprint $table) {
        Schema::dropIfExists('mrp_inventory_product_out');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_inventory_product_out', function (Blueprint $table) {
            //
        });
    }
}
