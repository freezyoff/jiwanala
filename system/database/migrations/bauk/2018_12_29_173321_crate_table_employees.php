<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CrateTableEmployees extends Migration
{
    protected $connection = 'bauk';
	protected $tables = [
		"person"=>"persons",
		'employee'=>'employees',
		'user'=>'users',
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
            $table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
            $table->integer('user_id')->unsigned()->nullable()->comment('ref table service.users');
			$table->increments('id');
			$table->integer('person_id')->unsigned();
			$table->date('registered_at')->nullabel()->comment('tanggal terdaftar');
			$table->date('resign_at')->nullabel()->comment('tanggal keluar / drop out');
            $table->boolean('active')->default(true);
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('user_id')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('person_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('person'));
        }, 'employee');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('employee');
    }
}
