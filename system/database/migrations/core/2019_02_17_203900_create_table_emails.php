<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableEmails extends Migration
{
	protected $connection = "core";
	protected $tables = [
		"email"=>"emails",
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
			$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
            $table->increments('id');
			$table->integer('person_id')->unsigned();
			$table->string('email')->unique();
			$table->boolean('default')->default(false);
			
			$table->foreign('person_id')->references('id')->on($this->getSchemaName('core').'.'.$this->getTableName('person'));
        }, 'email');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('email');
    }
}
