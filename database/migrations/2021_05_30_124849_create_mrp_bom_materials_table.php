<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpBomMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_bom_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("bom_id")->unsigned()->nullable();
            $table->bigInteger("material_id")->unsigned();
            $table->bigInteger("qty_material");
            $table->bigInteger("unit_id")->unsigned()->nullable();
            
            $table->foreign("bom_id")->references("id")->on("mrp_boms");
            $table->foreign("material_id")->references("id")->on("mrp_materials");
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
        Schema::dropIfExists('mrp_bom_materials');
    }
}
