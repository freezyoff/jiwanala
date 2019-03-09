<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableDivisions extends Migration
{
    protected $connection = "core";
	protected $tables = [
		"division"=>"divisions",
		"employee"=>"employees",
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
			$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
            $table->increments('id');
			$table->integer('code');
			$table->string('name');
			$table->string('alias');
			$table->integer('leader_employee_id')->unsigned()->nullable();
			
			$table->foreign('leader_employee_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('employee'));
        }, 'division');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('division');
    }
}
