<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("emails", function (Blueprint $table) {
            $table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
            $table->increments('id');
			$table->integer('person_id')->unsigned();
			$table->string('email')->unique();
			$table->boolean('default')->default(false);
			
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
		Schema::dropIfExists('emails');
    }
}
