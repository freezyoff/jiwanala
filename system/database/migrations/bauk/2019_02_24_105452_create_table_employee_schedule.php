<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableEmployeeSchedule extends Migration
{
 protected $connection = 'bauk';
	protected $tables = [
		'user'=>'users',
		'employee'=>'employees',
		'employee-schedules'=>'employee_schedules',
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
			$table->integer('employee_id')->unsigned()->comment('id on bauk.employee_attendance');
			$table->enum('day',[0,1,2,3,4,5,6])->comment('PHP & Carbon dayofweek = 0:minggu,6:sabtu');
			$table->time('arrival')->comment('Jam Masuk Kerja. batas maksimal kedatangan');
			$table->time('departure')->comment('Jam Pulang kerja. batas minimal kepulangan');
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('employee_id')->references('id')
				->on($this->getSchemaName('bauk').'.'.$this->getTableName('employee'));
		}, 'employee-schedules');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $this->dropSchema('employee-schedules');
    }
}
