<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStationToOeePlcValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oee_plc_values', function (Blueprint $table) {
            $table->float('station1')->nullable();
            $table->float('station1up')->nullable();
            $table->float('station2')->nullable();
            $table->float('station3_height')->nullable();
            $table->float('station3up_height')->nullable();
            $table->float('station3_high')->nullable();
            $table->float('station3_low')->nullable();
            $table->float('station3_noball')->nullable();
            $table->float('station3_twoball')->nullable();
            $table->float('station5_height')->nullable();
            $table->float('station5_high')->nullable();
            $table->float('station5_low')->nullable();
            $table->float('station6_high')->nullable();
            $table->float('station6_low')->nullable();
            $table->float('station8_high')->nullable();
            $table->float('station8_low')->nullable();
            $table->float('station9_interface')->nullable();
            $table->float('station10_high')->nullable();
            $table->float('station10_low')->nullable();
            $table->float('station10_direction')->nullable();
            $table->float('station10_presshigh')->nullable();
            $table->float('station10_presslevel')->nullable();
            $table->float('station11_presslow')->nullable();
            $table->float('station11_presslevel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oee_plc_values', function (Blueprint $table) {
            $table->dropColumn([
                'station1',
                'station1up',
                'station2',
                'station3_height',
                'station3up_height',
                'station3_noball',
                'station3_twoball',
                'station3_high',
                'station3_low',
                'station5_height',
                'station5_high',
                'station5_low',
                'station6_high',
                'station6_low',
                'station8_high',
                'station8_low',
                'station9_interface',
                'station10_high',
                'station10_low',
                'station10_direction',
                'station10_presshigh',
                'station10_presslevel',
                'station11_presslow',
                'station11_presslevel'
            ]);
        });
    }
}
