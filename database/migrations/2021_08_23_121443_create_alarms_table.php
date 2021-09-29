<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("alarm_master_id")->unsigned()->nullable();
            $table->bigInteger("alarm_detail_id")->unsigned()->nullable();

            $table->foreign("alarm_master_id")->references("id")->on("alarms_master")->onDelete('cascade');
            $table->foreign("alarm_detail_id")->references("id")->on("alarm_detail")->onDelete('cascade');
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
        Schema::dropIfExists('alarms');
    }
}
