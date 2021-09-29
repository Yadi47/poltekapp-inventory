<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrpCustomerDocs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mrp_customer_docs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("customer_id")->unsigned()->nullable();
            $table->string("dock_cd")->unsigned()->nullable();

            $table->foreign("customer_id")->references("id")->on("mrp_customers");
            
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
        Schema::dropIfExists('mrp_customer_docs');
    }
}
