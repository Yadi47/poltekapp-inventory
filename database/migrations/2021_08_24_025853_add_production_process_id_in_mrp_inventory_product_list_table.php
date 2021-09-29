<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductionProcessIdInMrpInventoryProductListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_inventory_product_list', function (Blueprint $table) {
            $table->bigInteger('production_process_id')->unsigned()->nullable();

            $table->foreign("production_process_id")->references("id")->on("mrp_production_process");

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
