<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProblemIdInMrpCounterMeasures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_counter_measures', function (Blueprint $table) {
            $table->bigInteger("problem_id")->unsigned()->nullable();

            $table->foreign("problem_id")->references("id")->on("mrp_problems");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_counter_measures', function (Blueprint $table) {
            //
        });
    }
}
