<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnInMrpForecasts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_forecasts', function (Blueprint $table) {
            DB::statement('ALTER TABLE mrp_forecasts ALTER COLUMN 
                  qty_forecast TYPE  INTEGER USING (qty_forecast::integer)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_forecasts', function (Blueprint $table) {
            DB::statement('ALTER TABLE mrp_forecasts ALTER COLUMN 
                  qty_forecast TYPE  INTEGER USING (qty_forecast::integer)');
        });
    }
}
