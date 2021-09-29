<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpInventoryMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_inventory_materials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("material_id")->unsigned()->nullable();
            $table->bigInteger("stock");
            $table->bigInteger("qty_incoming")->nullable();
            $table->string("date")->nullable();
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
        Schema::dropIfExists('mrp_inventory_materials');
    }
}
