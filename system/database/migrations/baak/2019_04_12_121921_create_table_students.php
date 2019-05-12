<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
			$table->timestamps();
			$table->unsignedInteger('creator');
            $table->increments('id');
			$table->unsignedInteger('user_id')->nullable();
			$table->unsignedInteger('person_id');
            $table->string('nis',20);
            $table->string('nisn',25)->nullable();
            $table->string('nik',20);
            $table->date('registered_at')->nullable()->comment('terdaftar');
			$table->date('transfer_at')->nullable()->comment('mutasi');
			$table->date('dropout_at')->nullable()->comment('tanpa keterangan / batal daftar');
			$table->date('graduate_at')->nullable()->comment('lulus');
			$table->unsignedInteger('father_person_id');
			$table->unsignedInteger('mother_person_id');
			$table->unsignedInteger('guardian_person_id')->nullable();
			$table->boolean('active')->default(true);
			
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
			$table->foreign('user_id')->references('id')->on('jiwanala_service.users');
			$table->foreign('person_id')->references('id')->on('jiwanala_core.persons');
			$table->foreign('father_person_id')->references('id')->on('jiwanala_core.persons');
			$table->foreign('mother_person_id')->references('id')->on('jiwanala_core.persons');
			$table->foreign('guardian_person_id')->references('id')->on('jiwanala_core.persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
