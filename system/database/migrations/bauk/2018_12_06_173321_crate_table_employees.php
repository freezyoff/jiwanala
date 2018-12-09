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
			$table->string('nip',10)->unique()->comment('Nomor Induk Pegawai <4 digit tahun masuk> <2 digit bulan lahir> <2 digit nomor urut>');
			$table->enum('work_time',['f','p'])->default('f')->comment('f: full time, p: part time');
			$table->timestamp('registered_at')->useCurrent()->comment('tanggal terdaftar');
			$table->timestamp('resign_at')->nullable()->comment('tanggal keluar / drop out');
            $table->boolean('active')->default(true);
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('user_id')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('person_id')->references('id')->on($this->getSchemaName('core').'.'.$this->getTableName('person'));
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
