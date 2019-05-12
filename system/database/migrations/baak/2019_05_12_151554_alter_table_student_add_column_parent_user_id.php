<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStudentAddColumnParentUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
			$table->unsignedInteger('father_user_id')->nullable()->after('father_person_id');
			$table->unsignedInteger('mother_user_id')->nullable()->after('mother_person_id');
			$table->unsignedInteger('guardian_user_id')->nullable()->after('guardian_person_id');
			
			$table->foreign('father_user_id')->references('id')->on('jiwanala_service.users');
			$table->foreign('mother_user_id')->references('id')->on('jiwanala_service.users');
			$table->foreign('guardian_user_id')->references('id')->on('jiwanala_service.users');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){}
}
