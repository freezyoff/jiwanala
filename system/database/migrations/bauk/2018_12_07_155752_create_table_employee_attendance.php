<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableEmployeeAttendance extends Migration
{
	protected $connection = 'bauk';
	protected $tables = [
		"person"=>"persons",
		'employee'=>'employees',
		'user'=>'users',
		'employee-attendance'=>'employee_attendance',
		'employee-attendance-attachments'=>'employee_attendance_attachments'
	];
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createSchema(function (Blueprint $table) {
            $table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
			$table->increments('id');
            $table->integer('employee_id')->unsigned()->comment('employee_id = id tabel bauk.employee');
            $table->date('date')->comment('tanggal histories');
			$table->enum('consent', [
				'ct',	//cuti tahunan
				'cs',	//cuti sakit
				'cb',	//cuti besar
				'ca',	//cuti bersama
				'ch',	//cuti hamil
				'cp',	//cuti penting
				'td',	//Tugas / Dinas
			])->nullable()->comment('izin tidak masuk');
			$table->time('time1')->nullable()->comment('jam finger masuk');
			$table->time('time2')->nullable()->comment('jam finger keluar');
			$table->time('time3')->nullable()->comment('jam finger keluar');
			$table->time('time4')->nullable()->comment('jam finger keluar');
			
			$table->foreign('employee_id')->references('id')
				->on($this->getSchemaName('bauk').'.'.$this->getTableName('employee'));
        },'employee-attendance');
		
		$this->createSchema(function (Blueprint $table) {
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
			$table->integer('employee_attendance_id')->unsigned()->comment('id on bauk.employee_attendance');
			$table->binary('attachment');
			$table->foreign('employee_attendance_id')->references('id')
				->on($this->getSchemaName('bauk').'.'.$this->getTableName('employee-attendance'));
		}, 'employee-attendance-attachments');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('employee-attendance-attachments');
        $this->dropSchema('employee-attendance');
    }
}
