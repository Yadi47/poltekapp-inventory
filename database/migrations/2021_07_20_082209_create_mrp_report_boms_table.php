<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpReportBomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_report_boms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("bom_id")->unsigned()->nullable();
            $table->bigInteger("bom_material_id")->unsigned()->nullable();
            $table->bigInteger("material_id")->unsigned();
            $table->bigInteger("unit_id")->unsigned()->nullable();
            
            $table->foreign("bom_id")->references("id")->on("mrp_boms");
            $table->foreign("bom_material_id")->references("id")->on("mrp_bom_materials");
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
        Schema::dropIfExists('mrp_report_boms');
    }
}
