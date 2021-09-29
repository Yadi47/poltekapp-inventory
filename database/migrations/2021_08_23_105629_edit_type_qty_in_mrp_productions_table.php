<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditTypeQtyInMrpProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_productions', function (Blueprint $table) {
            // $table->bigInteger('qty_plan')->nullable()->change();
            // $table->bigInteger('qty_entry')->nullable()->change();
            // $table->bigInteger('qty_reject')->nullable()->change();
            // $table->bigInteger('qty_good')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_productions', function (Blueprint $table) {
            //
        });
    }
}
