<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTargetMinMaxInMrpInventoryProductList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_inventory_product_list', function (Blueprint $table) {
            $table->bigInteger('target_min')->nullable();
            $table->bigInteger('target_max')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_inventory_product_list', function (Blueprint $table) {
            //
        });
    }
}
