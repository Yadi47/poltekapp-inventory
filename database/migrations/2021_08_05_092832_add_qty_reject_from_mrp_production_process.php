<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQtyRejectFromMrpProductionProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_production_process', function (Blueprint $table) {
            $table->string('qty_entry')->default(0);
            $table->string('qty_reject')->default(0);;
            $table->string('qty_good')->default(0);;
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_production_process', function (Blueprint $table) {
            $table->dropColumn('qty_entry');
            $table->dropColumn('qty_reject');
            $table->dropColumn('qty_good');
        
        });
    }
}
