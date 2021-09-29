<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOeePlcValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oee_plc_values', function (Blueprint $table) {
            $table->id();
            $table->string('datetime');
            $table->float('productionquantity');
            $table->float('passquantity');
            $table->float('failquantity');
            $table->bigInteger('abnormalycount');
            $table->bigInteger('abnormalytimehour');
            $table->bigInteger('abnormalytimesecond');
            $table->bigInteger('runningtimehour');
            $table->bigInteger('runningtimesecond');
            $table->string('device');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oee_plc_values');
    }
}
