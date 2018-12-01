<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableSchedules extends Migration
{
	protected $connection = 'baak';
	protected $tables = [
		'user'=>'users',
		'acyear'=>'acyears',
		'grade'=>'grades',
		'tutor'=>'tutors',
		'schedule'=>'schedules',
		'class'=>'classes',
		'class-schedule'=>'classes_schedules'
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
			$table->integer('acyear_id')->unsigned()->comment('Reference acyear.id');
			$table->integer('grade_id')->unsigned()->comment('Reference grade.id');
			$table->integer('day')->comment('0: minggu, 6:sabtu');
			$table->integer('index')->comment('nomor urut');
			$table->integer('length')->comment('lama waktu belajar dalam menit');
			$table->string('subject',100)->comment('mata pelajaran / mata kuliah');
			$table->integer('tutor_id')->unsigned()->comment('guru yang mengajar');
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('grade_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('grade'));
			$table->foreign('acyear_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('acyear'));
			$table->foreign('tutor_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('tutor'));
        }, 'schedule');
		
		$this->createSchema(function (Blueprint $table) {
            $table->timestamps();
			$table->integer('creator')->unsigned()->nullable();
			$table->integer('class_id')->unsigned()->nullable();
			$table->integer('schedule_id')->unsigned()->nullable();
			
			$table->primary(['class_id','schedule_id']);
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('class_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('class'));
			$table->foreign('schedule_id')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('schedule'));
        }, 'class-schedule');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('class-schedule');
        $this->dropSchema('schedule');
    }
}
