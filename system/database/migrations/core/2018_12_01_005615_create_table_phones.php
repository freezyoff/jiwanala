<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTablePhones extends Migration
{
	protected $connection = 'core';
	protected $tables = [
		"person"=>"persons",
		"phone"=>"phones", 
		"person-phone"=>"person_phones",
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
			$table->integer('person_id')->unsigned();
			$table->boolean('default')->default(false);
			$table->string('phone',25)->unique();
			$table->string('extension', 25)->nullable();
			
			$table->foreign('person_id')->references('id')->on($this->getSchemaName('core').'.'.$this->getTableName('person'));
        },'phone');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('person-phone');
        $this->dropSchema('phone');
    }
}
