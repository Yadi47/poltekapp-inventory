<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAlarmNameAndTagToAlarmsMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alarms_master', function (Blueprint $table) {
            $table->string("alarm_name");
            $table->string("alarm_tag");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alarms_master', function (Blueprint $table) {
            $table->dropColumn([
                'alarm_name',
                'alarm_tag',
            ]);
        });
    }
}
