<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnReferenceProductIdInMrpInventoryProductIncomingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('mrp_inventory_product_incoming', function (Blueprint $table) {
            $table->bigInteger("mrp_inventory_product_list_id");
           
            $table->dropForeign(['product_id']);

            $table->foreign('mrp_inventory_product_list_id')
                ->references('id')
                ->on('mrp_inventory_product_list')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_inventory_product_incoming', function (Blueprint $table) {
            //
        });
    }
}
