<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
	protected $connection = 'jn_core';
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
            $table->string('display_name');
			$table->string('description');
            $table->timestamps();
        });
		
		//create many to many table with users
		Schema::connection($this->connection)->create('users_roles', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
			$table->integer('role_id')->unsigned();
            $table->timestamps();
			
			$table->primary(['user_id','role_id']);
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::connection($this->connection)->dropIfExists('users_roles');
        Schema::connection($this->connection)->dropIfExists('roles');
    }
}