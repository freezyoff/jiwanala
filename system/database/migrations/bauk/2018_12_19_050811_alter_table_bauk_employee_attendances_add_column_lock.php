<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class AlterTableBaukEmployeeAttendancesAddColumnLock extends Migration
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
        $this->alterSchema(function (Blueprint $table){
			$table->boolean('locked')->default(0)->comment('flag kunci untuk persiapan laporan');
		}, 'employee-attendance');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->alterSchema(function (Blueprint $table){
			$table->dropColumn('locked');
		}, 'employee-attendance');
    }
}
