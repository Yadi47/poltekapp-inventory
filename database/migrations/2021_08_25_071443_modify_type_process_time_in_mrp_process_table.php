<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTypeProcessTimeInMrpProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_process', function (Blueprint $table) {
            DB::statement('ALTER TABLE mrp_process ALTER COLUMN 
                  process_time TYPE  INT USING (process_time::int)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_process', function (Blueprint $table) {
            //
        });
    }
}
