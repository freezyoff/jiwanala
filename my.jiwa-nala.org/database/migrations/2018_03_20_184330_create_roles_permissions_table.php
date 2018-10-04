<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesPermissionsTable extends Migration
{
	protected $connection = 'jn_core';
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//create many to many table with permissions
		Schema::connection($this->connection)->create('roles_permissions', function (Blueprint $table) {
			$table->integer('role_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->timestamps();
			
			$table->primary(['role_id', 'permission_id']);
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
        Schema::connection($this->connection)->dropIfExists('roles_permissions');
    }
}
