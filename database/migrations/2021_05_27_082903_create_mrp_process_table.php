<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_process', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('process_code')->unique();
            $table->string('process_name');
            $table->integer('process_time');
            $table->text('description')->nullable();
            $table->bigInteger("machine_id")->unsigned()->nullable();

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
        Schema::dropIfExists('mrp_process');
    }
}
