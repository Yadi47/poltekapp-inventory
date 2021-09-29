<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShiftToMrpPlanningProductions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mrp_planning_productions', function (Blueprint $table) {
            DB::statement('ALTER TABLE mrp_planning_productions ALTER COLUMN 
                  start_date TYPE date USING (start_date::date)');
            DB::statement('ALTER TABLE mrp_planning_productions ALTER COLUMN 
            finish_date TYPE date USING (finish_date::date)');
            DB::statement('ALTER TABLE mrp_planning_productions ALTER COLUMN 
            target_date TYPE date USING (target_date::date)');
            $table->bigInteger("shift_id")->unsigned()->nullable();
            
            $table->foreign("shift_id")->references("id")->on("mrp_shifts");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mrp_planning_productions', function (Blueprint $table) {
            //
        });
    }
}
