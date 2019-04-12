<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateTableEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create("employees", function (Blueprint $table) {
            $table->timestamps();
            $table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
			$table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->comment('ref table service.users');
			$table->integer('person_id')->unsigned();
			$table->string('nip',10)->unique()->comment('Nomor Induk Pegawai <4 digit tahun masuk> <2 digit bulan lahir> <2 digit nomor urut>');
			$table->enum('work_time',['f','p'])->default('f')->comment('f: full time, p: part time');
			$table->date('registered_at')->nullable()->comment('tanggal terdaftar');
			$table->date('resign_at')->nullable()->comment('tanggal keluar / drop out');
            $table->boolean('active')->default(true);
        });
		
		Schema::table("employees", function (Blueprint $table) {
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
			$table->foreign('user_id')->references('id')->on('jiwanala_service.users');
			//$table->foreign('person_id')->references('id')->on('jiwanala_core.persons');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('employees');
    }
}
