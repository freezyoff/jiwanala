<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePhones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create("phones", function (Blueprint $table) {
            $table->timestamps();
			$table->integer('creator')->unsigned()->nullable();
            $table->increments('id');
			$table->integer('person_id')->unsigned();
			$table->boolean('default')->default(false);
			$table->string('phone',25)->unique();
			$table->string('extension', 25)->nullable();
			
			$table->foreign('person_id')->references('id')->on('persons');
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
        Schema::dropIfExists('phones');
    }
}
