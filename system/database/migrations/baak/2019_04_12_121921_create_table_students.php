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
			$table->unsignedInteger('user_id')->nullable();
			$table->unsignedInteger('person_id');
            $table->string('id',20)->comment('Nomor Induk Siswa');
            $table->string('nisn',25)->nullable();
            $table->enum('register_type',['nw','tr'])->comment('nw:Siswa Baru, tr:Siswa Transfer');
            $table->date('registered_at')->nullable()->comment('terdaftar');
			$table->enum('unregister_type',['dr','gr','tr'])->comment('dr:drop out, gr:graduate, tr:transfer out');
			$table->date('unregister_at')->nullable()->comment('lulus');
			$table->unsignedInteger('father_person_id');
			$table->unsignedInteger('father_user_id')->nullable();
			$table->unsignedInteger('mother_person_id');
			$table->unsignedInteger('mother_user_id')->nullable();
			$table->unsignedInteger('guardian_person_id')->nullable();
			$table->unsignedInteger('guardian_user_id')->nullable();
			$table->boolean('active')->default(true);
			
			$table->primary('id');
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
			$table->foreign('user_id')->references('id')->on('jiwanala_service.users');
			$table->foreign('person_id')->references('id')->on('jiwanala_core.persons');
			$table->foreign('father_person_id')->references('id')->on('jiwanala_core.persons');
			$table->foreign('mother_person_id')->references('id')->on('jiwanala_core.persons');
			$table->foreign('guardian_person_id')->references('id')->on('jiwanala_core.persons');
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
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
