<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableJobs extends Migration
{
    protected $connection = 'core';
	protected $tables = [
		'user'=>'users',
		"permission"=>"permissions",
		'division'=>'divisions',
		'job'=>'jobs',
		'division_job'=>'divisions_jobs',
		'job_permission'=>'jobs_permissions',
	];
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//create jobs table
        if (!$this->schemaExist('job')){
			$this->createSchema(function (Blueprint $table) {
				$table->timestamps();
				$table->increments('id');
				$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
				$table->string('name')->default("");
				$table->string('display_name')->default("");
				$table->string('description')->default("");
				
				$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			}, 'job');
		}
		
		//create intermediate job & division table
		if (!$this->schemaExist('division_job')){
			$this->createSchema(function (Blueprint $table) {
				$table->timestamps();
				$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
				$table->integer('job_id')->unsigned();
				$table->integer('division_id')->unsigned();
				
				$table->primary(['job_id','division_id']);
				$table->foreign('job_id')->references('id')->on($this->getTableName('job'));
				$table->foreign('division_id')->references('id')->on($this->getSchemaName('core').'.'.$this->getTableName('division'));
				$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			}, 'division_job');
		}
		
		//create intermediate job & permission table
		if (!$this->schemaExist('job_permission')){
			$this->createSchema(function (Blueprint $table) {
				$table->timestamps();
				$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
				$table->integer('job_id')->unsigned();
				$table->integer('permission_id')->unsigned();
				
				$table->primary(['job_id','permission_id']);
				$table->foreign('job_id')->references('id')->on($this->getTableName('job'));
				$table->foreign('permission_id')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('permission'));
				$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			}, 'job_permission');
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('job_permission');
		$this->dropSchema('division_job');
		$this->dropSchema('job');
    }
}
