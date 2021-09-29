<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_productions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('production_code')->unique();
            $table->string('production_name');
            $table->string('qty_plan');
            $table->string('qty_entry');
            $table->string('qty_reject');
            $table->string('qty_good');
            $table->string('date_start');
            $table->string('date_finish');
            $table->bigInteger("shift_id")->unsigned()->nullable();
            $table->bigInteger("problem_id")->unsigned()->nullable();
            $table->bigInteger("planning_id")->unsigned()->nullable();
            $table->bigInteger("counter_measure_id")->unsigned()->nullable();
            $table->bigInteger("machine_id")->unsigned()->nullable();

            $table->foreign("planning_id")->references("id")->on("mrp_planning_productions");
            $table->foreign("shift_id")->references("id")->on("mrp_shifts");
            $table->foreign("problem_id")->references("id")->on("mrp_problems");
            $table->foreign("counter_measure_id")->references("id")->on("mrp_counter_measures");
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
        Schema::dropIfExists('mrp_productions');
    }
}
