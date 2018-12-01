<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableAddress extends Migration
{
	protected $connection = "bauk";
	protected $tables = [
		"person"=>"persons",
		"address"=>"addresses", 
		"person-address"=>"person_addresses"
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
			$table->string('address', 200)->nullable();
            $table->string('neighbourhood', 3)->nullable()->comment('RT');
            $table->string('hamlet', 3)->nullable()->comment('RW');
            $table->string('urban', 50)->nullable()->comment('Keluarahan');
            $table->string('sub_disctrict', 50)->nullable()->comment('Kecamatan');
            $table->string('district', 50)->nullable()->comment('Kota / Kabupaten');
            $table->string('province', 50)->nullable()->comment('Provinsi');
            $table->string('post_code', 20)->nullable()->comment('Kode Pos');
        },'address');
		
		$this->createSchema(function (Blueprint $table) {
            $table->timestamps();
			$table->integer('creator')->unsigned()->nullable();
			$table->integer('person_id')->unsigned();
			$table->integer('address_id')->unsigned();
			
			$table->primary(['person_id','address_id']);
			$table->foreign('person_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('person'));
			$table->foreign('address_id')->references('id')->on($this->getSchemaName('bauk').'.'.$this->getTableName('address'));
        },'person-address');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('person-address');
        $this->dropSchema('address');
    }
}
