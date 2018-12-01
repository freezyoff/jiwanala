<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableClasses extends Migration
{
	protected $connection = 'baak';
	protected $tables = [
		"user"=>"users",
		'tutor'=>'tutors',
		"class"=>"classes",
		'acyear'=>'acyears',
		'student-class'=>'students_classes',
		'grade'=>'grades',
		'student'=>'students'
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
			$table->integer('grade_id')->unsigned()->comment('reference grade.id');
			$table->integer('acyear_id')->unsigned()->comment('reference acyear.id');
			$table->integer('home_tutor_id')->unsigned()->comment('wali kelas');
			$table->integer('paralel')->unsigned()->comment('nomor kelas parael');
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('grade_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('grade'));
			$table->foreign('acyear_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('acyear'));
			$table->foreign('home_tutor_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('tutor'));
        }, 'class');
		
		$this->createSchema(function(Blueprint $table){
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable();
			$table->integer('student_id')->unsigned()->comment('reference student.id');
			$table->integer('class_id')->unsigned()->comment('reference class.id');
            
			$table->primary(['student_id','class_id']);
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('student_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('student'));
			$table->foreign('class_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('class'));
		},'student-class');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('student-class');
        $this->dropSchema('class');
    }
}
