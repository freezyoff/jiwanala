<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEmployeeAssignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("employees_assignments", function (Blueprint $table) {
			$table->dropColumn('job_position_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
