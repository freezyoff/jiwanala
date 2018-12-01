<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableAttendaces extends Migration
{
	protected $connection = 'baak';
	protected $tables = [
		'user'=>'users',
		'tutor'=>'tutors',
		'student'=>'students',
		'class'=>'classes',
		'schedule'=>'schedules',
		'class-schedule'=>'classes_schedules',
		'student-attendance'=>'student_attendance',
		'tutor-attendance'=>'tutor_attendance',
	];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		$this->createSchema(function(Blueprint $table){
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable();
			$table->integer('class_id')->unsigned()->comment('reference classes.id');
			$table->integer('schedule_id')->unsigned()->comment('reference schedules.id');
			$table->integer('student_id')->unsigned()->comment('reference student.id');
			$table->text('comment')	->comment('komentar');
			
			$table->primary(['class_id','schedule_id','student_id']);
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('class_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('class'));
			$table->foreign('schedule_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('schedule'));
			$table->foreign('student_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('student'));
		},'student-attendance');
		
		$this->createSchema(function(Blueprint $table){
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable();
			$table->integer('class_id')->unsigned()->comment('reference classes.id');
			$table->integer('schedule_id')->unsigned()->comment('reference schedules.id');
			$table->integer('tutor_id')->unsigned()->comment('reference tutor.id');
			$table->text('comment')->comment('komentar');
			
			$table->primary(['class_id','schedule_id','tutor_id']);
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('class_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('class'));
			$table->foreign('schedule_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('schedule'));
			$table->foreign('tutor_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('tutor'));
		},'tutor-attendance');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('tutor-attendance');
        $this->dropSchema('student-attendance');
    }
}
