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
			$table->integer('creator')->unsigned()->nullable();
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password')->nullabe();
            $table->boolean('activated')->default(true);
            $table->rememberToken();
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
