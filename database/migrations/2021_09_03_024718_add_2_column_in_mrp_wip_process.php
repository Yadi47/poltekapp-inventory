<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Add2ColumnInMrpWipProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_wip_process', function (Blueprint $table) {
            //
            $table->string("type")->nullable();
            $table->integer("bom_id")->unsigned()->nullable();
            $table->foreign("bom_id")->references("id")->on("mrp_boms");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_wip_process', function (Blueprint $table) {
            //
        });
    }
}
