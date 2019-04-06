<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableGrades extends Migration
{
    protected $connection = 'baak';
	protected $tables = [
		"user"=>"users",
		'division'=>'divisions',
		'grade'=>'grades'
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
			$table->integer('division')->unsigned();
			$table->integer('code')->unique()->comment('Kode Tingkat sekolah. <2 digit>');
			$table->string('name', 100)->comment('Nama tingkat sekolah. PG, TK, SD, SMP');
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('division')->references('id')->on($this->getSchemaName('baak').'.'.$this->getTableName('division'));
        }, 'grade');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('grade');
    }
}
