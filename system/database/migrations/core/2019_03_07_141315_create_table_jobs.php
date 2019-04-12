<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
        Schema::create("jobs", function (Blueprint $table) {
			$table->timestamps();
			$table->increments('id');
			$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
			$table->string('name')->default("");
			$table->string('display_name')->default("");
			$table->string('description')->default("");
			
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
		});
		
		//create intermediate job & division table
		Schema::create("divisions_jobs", function (Blueprint $table) {
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
			$table->integer('job_id')->unsigned();
			$table->integer('division_id')->unsigned();
			
			$table->primary(['job_id','division_id']);
			$table->foreign('job_id')->references('id')->on('jobs');
			$table->foreign('division_id')->references('id')->on('divisions');
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
		});
		
		//create intermediate job & permission table
		Schema::create("jobs_permissions", function (Blueprint $table) {
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
			$table->integer('job_id')->unsigned();
			$table->integer('permission_id')->unsigned();
			
			$table->primary(['job_id','permission_id']);
			$table->foreign('job_id')->references('id')->on('jobs');
			$table->foreign('permission_id')->references('id')->on('jiwanala_service.permissions');
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach(['jobs_permissions','divisions_jobs','jobs'] as $table){
			Schema::dropIfExists($table);
		}
    }
}
