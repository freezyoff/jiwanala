<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('roles', function (Blueprint $table) {
            $table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
			$table->string('id',50);
			$table->string('context')->comment('Konteks Level Role');
			$table->string('display_name')->default("");
			$table->string('description')->default("");
			
			$table->primary('id');
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
        });
		
		Schema::create('users_roles', function (Blueprint $table) {
            $table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
			$table->integer('user_id')->unsigned();
			$table->string('role_id',50);
			$table->text('options')->nullable()->comment('as json');
			
			$table->primary(['user_id','role_id']);
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('role_id')->references('id')->on('roles');
			
        });
		
		Schema::create('permissions', function (Blueprint $table) {
			$table->timestamps();
            $table->integer('creator')->unsigned()->nullable();
			$table->string('id',50);
			$table->string('context')->comment('Konteks Level permission');
			$table->string('display_name')->default("");
			$table->string('description')->default("");
			
			$table->primary('id');
			$table->foreign('creator')->references('id')->on('users');
		});
		
		Schema::create('roles_permissions', function (Blueprint $table) {
            $table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
			$table->string('role_id',50);
			$table->string('permission_id',50);
			
			
			$table->primary(['role_id','permission_id']);
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
			$table->foreign('role_id')->references('id')->on('roles');
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
		foreach(['users_roles', 'roles_permissions', 'permissions','roles'] as $table){
			Schema::dropIfExists($table);			
		}
    }
}