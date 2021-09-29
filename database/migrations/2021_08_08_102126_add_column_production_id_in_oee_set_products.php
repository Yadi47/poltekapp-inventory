<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProductionIdInOeeSetProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oee_set_products', function (Blueprint $table) {
            $table->integer('production_id')->nullable();
            $table->foreign("production_id")->references("id")->on("mrp_productions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oee_set_products', function (Blueprint $table) {
            $table->integer('production_id');
        });
    }
}
