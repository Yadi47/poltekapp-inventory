<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nik')->unique();
            $table->string('employee_name');
            $table->string('departement');
            $table->string('section');
            $table->string('title');
            $table->string('grade');
            $table->bigInteger("place_id")->unsigned()->nullable();
            $table->bigInteger("shift_id")->unsigned()->nullable();
            $table->text('description')->nullable();

            $table->foreign("place_id")->references("id")->on("mrp_places");
            $table->foreign("shift_id")->references("id")->on("mrp_shifts");
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
        Schema::dropIfExists('mrp_employees');
    }
}
