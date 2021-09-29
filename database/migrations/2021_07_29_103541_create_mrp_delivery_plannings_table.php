<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpDeliveryPlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_delivery_plannings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('do_code')->unique();
            $table->date('do_date');
            $table->date('delivery_date');
            $table->text('description')->nullable();
            $table->bigInteger("customer_id")->unsigned()->nullable();
            $table->foreign("customer_id")->references("id")->on("mrp_customers")->onDelete('set null');
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
        Schema::dropIfExists('mrp_delivery_plannings');
    }
}
