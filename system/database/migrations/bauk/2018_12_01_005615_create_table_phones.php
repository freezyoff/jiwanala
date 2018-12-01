<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTablePhones extends Migration
{
	protected $connection = 'bauk';
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
			$table->string('phone',25)->unique();
			$table->boolean('reachable')->default(true);
        },'phone');
		
		$this->createSchema(function (Blueprint $table) {
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable();
			$table->integer('person_id')->unsigned();
			$table->integer('phone_id')->unsigned();
			
			$table->primary(['person_id','phone_id']);
			$table->foreign('person_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('person'));
			$table->foreign('phone_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('phone'));
		},'person-phone');
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
