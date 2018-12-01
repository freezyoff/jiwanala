<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableStudents extends Migration
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
			$table->date('registered_at')->nullabel()->comment('tanggal terdaftar');
			$table->date('graduated_at')->nullabel()->comment('tanggal lulus');
			$table->date('resign_at')->nullabel()->comment('tanggal keluar / drop out');
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('user_id')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('person_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('person'));
        }, 'student');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('student');
    }
}
