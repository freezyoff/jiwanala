<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployeesAssignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("employees_assignments", function (Blueprint $table) {
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
			$table->integer('division_id')->unsigned()->comment('ref table core.divisions');
			$table->integer('employee_id')->unsigned()->comment('ref table bauk.employees');
			$table->string('job_position_id',20)->nullable()->comment('ref table core.job_positions');
			
			$table->primary(['division_id','employee_id']);
			//$table->foreign('division_id')->references('id')->on($this->getSchemaName('core').'.'.$this->getTableName('division'));
			//$table->foreign('employee_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('employee'));
			//$table->foreign('job_position_id')->references('code')->on($this->getSchemaName('core').'.'.$this->getTableName('job-position'));
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('employees_assignments');
    }
}
