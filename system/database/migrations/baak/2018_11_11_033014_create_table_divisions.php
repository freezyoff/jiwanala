<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableDivisions extends Migration
{
	protected $connection = 'baak';
	protected $tables = [
		'division'=>'divisions',
		'user'=>'users'
	];
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		$this->createSchema(function (Blueprint $table) {
			//$table->comment('Lembaga');
            $table->timestamps();
			$table->integer('creator')->unsigned()->nullable();
            $table->increments('id');
			$table->integer('code')->unique()->comment('kode lembaga');
			$table->string('name',100);
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
        },'division');
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
