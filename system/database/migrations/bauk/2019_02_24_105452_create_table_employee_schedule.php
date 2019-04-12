<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployeeSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("employee_schedules", function (Blueprint $table) {
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->comment('id on bauk.employee_attendance');
			$table->enum('day',[0,1,2,3,4,5,6])->comment('PHP & Carbon dayofweek = 0:minggu,6:sabtu');
			$table->time('arrival')->comment('Jam Masuk Kerja. batas maksimal kedatangan');
			$table->time('departure')->comment('Jam Pulang kerja. batas minimal kepulangan');
			
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
		Schema::dropIfExists('employee_schedules');
    }
}
