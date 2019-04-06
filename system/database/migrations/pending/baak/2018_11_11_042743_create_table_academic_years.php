<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableAcademicYears extends Migration
{
    protected $connection = 'baak';
	protected $tables = [
		"user"=>"users",
		'acyear'=>'acyears',
	];
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		$this->createSchema(function (Blueprint $table) {
			//$table->comment('Tahun Akademik');
            $table->timestamps();
			$table->integer('creator')->unsigned()->nullable();
            $table->increments('id');
			$table->integer('code')->unique()->comment('Kode semester, <4 digit Tahun>');
			$table->string('name',100)->comment('Nama Tahun Akademik');
			$table->timestamp('start')->useCurrent();
			$table->timestamp('end')->useCurrent();
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
        }, 'acyear');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('acyear');
    }
}
