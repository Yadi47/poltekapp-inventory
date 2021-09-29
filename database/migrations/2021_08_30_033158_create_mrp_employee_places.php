<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpEmployeePlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_employee_places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("employee_id")->unsigned()->nullable();
            $table->bigInteger("place_id")->unsigned()->nullable();

            $table->foreign("employee_id")->references("id")->on("mrp_employees");
            $table->foreign("place_id")->references("id")->on("mrp_places");
           
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
        Schema::dropIfExists('mrp_employee_places');
    }
}
