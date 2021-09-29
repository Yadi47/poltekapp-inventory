<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDateFinishColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_productions', function ($table) {
            DB::statement('ALTER TABLE mrp_productions ALTER COLUMN 
                  date_start TYPE date USING (date_start::date)');
                  DB::statement('ALTER TABLE mrp_productions ALTER COLUMN 
                  date_finish TYPE date USING (date_finish::date)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_productions', function ($table) {
            $table->string('date_start')->change();
            $table->string('date_finish')->change();
        });
    }
}
