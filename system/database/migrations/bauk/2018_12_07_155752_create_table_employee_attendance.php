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
		'employee-attendance'=>'employee_attendance'
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
			$table->time('time1')->nullable()->comment('jam finger masuk');
			$table->time('time2')->nullable()->comment('jam finger keluar');
			$table->time('time3')->nullable()->comment('jam finger keluar');
			$table->time('time4')->nullable()->comment('jam finger keluar');
			$table->boolean('locked')->default(0)->comment('flag kunci untuk persiapan laporan');
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('employee_id')->references('id')
				->on($this->getSchemaName('bauk').'.'.$this->getTableName('employee'));
        },'employee-attendance');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('employee-attendance');
    }
}
