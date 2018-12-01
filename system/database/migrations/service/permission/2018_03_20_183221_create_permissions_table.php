<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
	protected $connection = 'service';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::connection($this->connection)
			->create('permissions', function (Blueprint $table) {
            $table->integer('creator')->unsigned()->nullable();
			$table->timestamps();
			$table->increments('id');
			$table->string('key')->unique();
			$table->string('context')->comment('Konteks Level permission');
			$table->string('display_name')->default("");
			$table->string('description')->default("");
			
			$table->foreign('creator')->references('id')->on('users');
		});
		
		//	many to many relation with users table
		Schema::connection($this->connection)
			->create('users_permissions', function(Blueprint $table){
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->integer('permission_id')->unsigned();
			
			$table->primary(['user_id','permission_id']);
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('permission_id')->references('id')->on('permissions');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::connection($this->connection)->dropIfExists('users_permissions');
        Schema::connection($this->connection)->dropIfExists('permissions');
    }
}