<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnInMrpMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_materials', function (Blueprint $table) {
            DB::statement('ALTER TABLE mrp_materials ALTER COLUMN 
            price TYPE  INTEGER USING (price::float)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_materials', function (Blueprint $table) {
            //
        });
    }
}
