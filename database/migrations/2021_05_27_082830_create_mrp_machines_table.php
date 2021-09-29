<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_machines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('machine_code')->unique();
            $table->string('machine_name')->unique();
            $table->string('type');
            $table->string('brand');
            $table->integer('capacity');
            $table->text('description')->nullable();
            $table->bigInteger("unit_id")->unsigned()->nullable();
            $table->bigInteger("place_id")->unsigned()->nullable();
            $table->bigInteger("supplier_id")->unsigned()->nullable();

            $table->foreign("unit_id")->references("id")->on("mrp_units");
            $table->foreign("place_id")->references("id")->on("mrp_places");
            $table->foreign("supplier_id")->references("id")->on("mrp_suppliers");

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
        Schema::dropIfExists('mrp_machines');
    }
}
