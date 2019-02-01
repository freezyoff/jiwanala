<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableEmployeeAttendanceReports extends Migration
{
    protected $connection = 'bauk';
	protected $tables = [
		'user'=>'users',
		'employee-attendance-report'=>'employee_attendance_reports'
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
			$table->integer('year')->comment('periode tahun laporan');
			$table->integer('month')->comment('periode bulan laporan');
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
        }, 'employee-attendance-report');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('employee-attendance-report');
    }
}
