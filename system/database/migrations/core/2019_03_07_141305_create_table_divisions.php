<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableDivisions extends Migration
{
    protected $connection = "core";
	protected $tables = [
		"division"=>"divisions",
		"user"=>"users",
	];
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!$this->schemaExist('division')){
			$this->createSchema(function (Blueprint $table) {
				$table->timestamps();
				$table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
				$table->integer('id')->unsigned();
				$table->string('name');
				$table->string('alias');
				
				$table->primary('id');
				$table->foreign('creator')->references('id')->on('jiwanala_service.users');
			}, 'division');
		}
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
