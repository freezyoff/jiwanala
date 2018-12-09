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
		'employee-attendance-histories'=>'employee_attendance_histories'
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
            $table->integer('employee_id')->unsigned()->comment('employee_id = id tabel bauk.employee');
            $table->date('date')->nullable()->comment('employee_id = id tabel bauk.employee');
			$table->enum('consent', [
				'ct',	//cuti tahunan
				'cs',	//cuti sakit
				'cb',	//cuti besar
				'ca',	//cuti bersama
				'ch',	//cuti hamil
				'cp',	//cuti penting
			])->nullable()->comment('izin tidak masuk');
			
			$table->primary(['employee_id','date']);
			$table->foreign('employee_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('employee'));
        },'employee-attendance');
		
		$this->createSchema(function (Blueprint $table) {
            $table->timestamps();
			$table->integer('employee_id')->unsigned()->comment('employee_id = id tabel bauk.employee');
            $table->date('date')->nullable()->comment('employee_id = id tabel bauk.employee');
            $table->time('time1')->comment('jam finger');
            $table->time('time2')->comment('jam finger');
            $table->time('time3')->comment('jam finger');
            $table->time('time4')->comment('jam finger');
			$table->primary(['employee_id','date']);
			$table->foreign('employee_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('employee'));
		},'employee-attendance-histories');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('employee-attendance');
        $this->dropSchema('employee-attendance-histories');
    }
}
