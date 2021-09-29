<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityMrpProductionProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_production_process', function (Blueprint $table) {
            $table->bigInteger('qty_entry')->default(0);
            $table->bigInteger('qty_reject')->default(0);;
            $table->bigInteger('qty_good')->default(0);;
            
        });
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
