<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableGuardians extends Migration
{
	protected $connection = 'baak';
	protected $tables = [
		"student"=>"students",
		"guardian"=>"guardians", 
		"student-guardian"=>"student_guardians",
		"user"=>"users",
		"person"=>"persons",
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
			$table->integer('user_id')->unsigned()->nullable();
            $table->increments('id');
			$table->integer('person_id')->unsigned();
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('user_id')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('person_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('person'));
		}, 'guardian');
		
		$this->createSchema(function (Blueprint $table) {
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable();
			$table->integer('guardian_id')->unsigned();
			$table->integer('student_id')->unsigned();
			
			$table->primary(['guardian_id','student_id']);
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('guardian_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('guardian'));
			$table->foreign('student_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('student'));
		}, 'student-guardian');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('student-guardian');
        $this->dropSchema('guardian');
    }
}
