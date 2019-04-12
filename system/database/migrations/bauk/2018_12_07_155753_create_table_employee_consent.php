<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployeeConsent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("employee_consents", function (Blueprint $table) {
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->comment('employee_id = id tabel bauk.employee');
			$table->enum('consent', [
				'ct',	//cuti tahunan
				'cs',	//cuti sakit
				'cb',	//cuti besar
				'ca',	//cuti bersama
				'ch',	//cuti hamil
				'cp',	//cuti penting
				'td',	//Tugas / Dinas
				'tl',	//Izin Datang Terlambat / Pulang Awal
				'tf',	//Izin Tidak Finger Datang / Pulang
			])->nullable()->comment("
				ct: cuti tahunan,
				cs: cuti sakit
				cb: cuti besar
				ca: cuti bersama
				ch: cuti hamil
				cp: cuti penting
				td: izin tugas / dinas
				tl: izin datang terlambat / pulang awal
				tf: izin tidak finger datang / pulang
			");
			$table->date('start')->comment('tanggal mulai cuti/izin');
			$table->date('end')->comment('tanggal selesai cuti/izin');
			$table->boolean('locked')->default(false)->comment('flag kunci untuk persiapan laporan');
			
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
			$table->foreign('employee_id')->references('id')->on('employees');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
		Schema::dropIfExists('employee_consents');
    }
}
