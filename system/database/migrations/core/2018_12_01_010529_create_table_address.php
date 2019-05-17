<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAddress extends Migration
{	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create("addresses", function (Blueprint $table) {
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
			
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
        });
		
		Schema::create("persons_addresses", function (Blueprint $table) {
            $table->timestamps();
			$table->integer('creator')->unsigned()->nullable();
			$table->integer('person_id')->unsigned();
			$table->integer('address_id')->unsigned();
			$table->enum('type',['h','w'])
				->default('h')
				->comment('h:home, w:work');
			
			$table->primary(['person_id','address_id']);
			$table->foreign('person_id')->references('id')->on('persons');
			$table->foreign('address_id')->references('id')->on('addresses');
			
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons_addresses');
        Schema::dropIfExists('addresses');
    }
}
