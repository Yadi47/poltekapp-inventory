<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpWipProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_wip_process', function (Blueprint $table) {
            $table->id();
            $table->integer('mrp_production_process_machine_product_id');
            $table->integer('shift_id');
            $table->date('date');
            $table->float('qty_total');
            $table->float('qty_plan');
            $table->float('qty_good');
            $table->float('qty_reject');
            $table->timestamps();

            $table->foreign("mrp_production_process_machine_product_id")->references("id")->on("mrp_production_process_machine_product");
            $table->foreign("shift_id")->references("id")->on("mrp_shifts");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mrp_wip_process');
    }
}
