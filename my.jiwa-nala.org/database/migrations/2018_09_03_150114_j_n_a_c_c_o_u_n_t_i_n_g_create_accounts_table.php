<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JNACCOUNTINGCreateAccountsTable extends Migration
{
	protected $connection = 'jn_accounting';
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
		Schema::connection($this->connection)->create('accounts', function (Blueprint $table) {
            $table->timestamps();
            $table->increments('id');
            $table->string('code', 20);
            $table->string('name', 45);
            $table->boolean('isRoot')->default(false);
            $table->integer('parent_id')->default(null);
            $table->enum('def_position', ['db', 'cr'])->comment('db: Debet, cr: Kredit')->default('db');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::connection($this->connection)->dropIfExists('accounts');
    }
}
