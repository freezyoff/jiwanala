<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableTutors extends Migration
{
    protected $connection = 'baak';
	protected $tables = [
		"user"=>"users",
		'tutor'=>'tutors',
		'employee'=>'employees',
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
			$table->integer('creator')->unsigned()->nullable();
            $table->increments('id');
			$table->integer('employee_id')->unsigned();
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('employee_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('employee'));
        }, 'tutor');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('tutor');
    }
}
