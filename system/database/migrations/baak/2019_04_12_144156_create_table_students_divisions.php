<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStudentsDivisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_divisions', function (Blueprint $table) {
            $table->timestamps();
			$table->unsignedInteger('creator');
			$table->unsignedInteger('student_id');
			$table->unsignedInteger('division_id');
			
			$table->primary(['student_id','division_id']);
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
			$table->foreign('student_id')->references('id')->on('students');
			$table->foreign('division_id')->references('id')->on('jiwanala_core.divisions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_divisions');
    }
}
