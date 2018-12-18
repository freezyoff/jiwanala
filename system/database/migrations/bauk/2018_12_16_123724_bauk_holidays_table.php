<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class BaukHolidaysTable extends Migration
{
	protected $connection = 'bauk';
	protected $tables = [
		'holiday'=>'holidays',
		'user'=>'users'
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
			$table->String('name')->comment('nama hari libur');
			$table->date('start')->comment('tanggal mulai libur');
			$table->date('end')->comment('tanggal selesai libur');
			$table->boolean('repeat')->default(0)->comment('diulang setiap bulan yang sama');
			
			$table->foreign('creator')->references('id')->on($this->getSchemaName('service').'.'.$this->getTableName('user'));
		},'holiday');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('holiday');
    }
}
