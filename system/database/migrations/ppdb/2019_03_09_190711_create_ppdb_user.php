<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreatePpdbUser extends Migration
{
    protected $connection = 'ppdb';
	protected $tables = [
		'user'=>'users',
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
			$table->string('email')->comment('username');
			$table->string('token',6)->comment('kode verifikasi');
			
			$table->primary('email');
		}, 'user');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $this->dropSchema('user');
    }
}
