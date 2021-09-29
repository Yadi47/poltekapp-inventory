<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOeeAlarmListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oee_alarm_list', function (Blueprint $table) {
            $table->id();
            $table->integer('index_array');
            $table->string('text');
            $table->integer('abnormal');
            $table->dateTime('datetime');
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
        Schema::dropIfExists('oee_alarm_list');
    }
}
