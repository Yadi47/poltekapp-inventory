<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableOeePlcValuesChangeMachinestatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oee_plc_values', function (Blueprint $table) {
            DB::statement('ALTER TABLE oee_plc_values ALTER COLUMN 
                  machinestatus TYPE  BOOLEAN USING (machinestatus::boolean)');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oee_plc_values', function (Blueprint $table) {
            DB::statement('ALTER TABLE oee_plc_values ALTER COLUMN 
            machinestatus TYPE  BOOLEAN USING (machinestatus::boolean)');

        });
    }
}