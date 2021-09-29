<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpProductionProcessMachineProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_production_process_machine_product', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('production_id');
            $table->bigInteger('process_id');
            $table->bigInteger('machine_id');
            $table->bigInteger('product_id');
            $table->timestamps();

            
            $table->foreign("production_id")->references("id")->on("mrp_productions");
            $table->foreign("process_id")->references("id")->on("mrp_process");
            $table->foreign("machine_id")->references("id")->on("mrp_machines");
            $table->foreign("product_id")->references("id")->on("mrp_products");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mrp_production_process_and_machine');
    }
}
