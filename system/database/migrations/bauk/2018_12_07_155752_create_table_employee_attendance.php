<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployeeAttendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("employee_attendance", function (Blueprint $table) {
            $table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
			$table->increments('id');
            $table->integer('employee_id')->unsigned()->comment('employee_id = id tabel bauk.employee');
            $table->date('date')->comment('tanggal histories');
			$table->time('time1')->nullable()->comment('jam finger masuk');
			$table->time('time2')->nullable()->comment('jam finger keluar');
			$table->time('time3')->nullable()->comment('jam finger keluar');
			$table->time('time4')->nullable()->comment('jam finger keluar');
			$table->boolean('locked')->default(0)->comment('flag kunci untuk persiapan laporan');
			
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
			$table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_attendance');
    }
}
