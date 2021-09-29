<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpProcessMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_process_machines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("process_machines_id")->unsigned()->nullable();
            $table->bigInteger("machine_id")->unsigned()->nullable();

            $table->foreign("process_machines_id")->references("id")->on("mrp_process");
            $table->foreign("machine_id")->references("id")->on("mrp_machines");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mrp_process_machines');
    }
}
