<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('material_code')->unique();
            $table->string('material_name');
            $table->string('part_name');
            $table->float('dim_long');
            $table->float('dim_width');
            $table->float('dim_height');
            $table->float('dim_weight');
            $table->string('colour');
            $table->bigInteger('price');
            $table->bigInteger("supplier_id")->unsigned()->nullable();
            $table->bigInteger("unit_id")->unsigned()->nullable();
            $table->text('description')->nullable();

            $table->foreign("supplier_id")->references("id")->on("mrp_suppliers");
            $table->foreign("unit_id")->references("id")->on("mrp_units");
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
        Schema::dropIfExists('mrp_materials');
    }
}
