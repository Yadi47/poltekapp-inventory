<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpInventoryMaterialListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_inventory_material_list', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_masuk_conv');
            $table->date('lot_material');
            $table->bigInteger('stock');
            $table->bigInteger("material_id")->unsigned()->nullable();
            $table->text('description')->nullable();

            $table->foreign("material_id")->references("id")->on("mrp_materials");
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
        Schema::dropIfExists('mrp_inventory_material_list');
    }
}
