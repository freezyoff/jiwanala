<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableEmployeeConsent extends Migration
{
    protected $connection = 'bauk';
	protected $tables = [
		'employee'=>'employees',
		'user'=>'users',
		'employee-consents'=>'employee_consents'
	];
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createSchema(function (Blueprint $table){
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->comment('employee_id = id tabel bauk.employee');
			$table->enum('consent', [
				'ct',	//cuti tahunan
				'cs',	//cuti sakit
				'cb',	//cuti besar
				'ca',	//cuti bersama
				'ch',	//cuti hamil
				'cp',	//cuti penting
				'td',	//Tugas / Dinas
			])->nullable()->comment('izin tidak masuk');
			$table->date('start')->comment('tanggal mulai cuti/izin');
			$table->date('end')->comment('tanggal selesai cuti/izin');
			$table->boolean('locked')->comment('flag kunci untuk persiapan laporan');
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
			$table->foreign('employee_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('employee'));
		}, 'employee-consents');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $this->dropSchema('employee-consents');
    }
}
