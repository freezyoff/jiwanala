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
			$table->timestamp('registered_at')->useCurrent()->comment('tanggal terdaftar');
			$table->timestamp('graduated_at')->nullable()->comment('tanggal lulus');
			$table->timestamp('resign_at')->nullable()->comment('tanggal keluar / drop out');
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('user_id')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('person_id')->references('id')->on($this->getSchemaName('core').'.'.$this->getTableName('person'));
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
