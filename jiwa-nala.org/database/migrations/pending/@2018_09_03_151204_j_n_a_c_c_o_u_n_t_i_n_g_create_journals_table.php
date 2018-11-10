<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JNACCOUNTINGCreateJournalsTable extends Migration
{
    protected $connection = 'jn_accounting';
	protected $table = 'journals';
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
		Schema::connection($this->connection)->create($this->table, function (Blueprint $table) {
            $table->timestamps();
            $table->increments('id');
            $table->date('date', 20);
            $table->string('reference', 45)->comment('Dokumen Referen: misal voucher');
            $table->integer('creator_user_id')->comment('user who make this record')->unsigned();
			$table->integer('account_db_id')->unsigned()->comment('foreign key tabel `accounts`');
            $table->double('account_db_balance');
			$table->integer('account_cr_id')->unsigned()->comment('foreign key tabel `accounts`');
            $table->double('account_cr_balance');
            $table->text('memo', 45);
            $table->boolean('verified')->default(false);
            $table->datetime('verified_at');
            $table->boolean('approved')->default(false);
            $table->datetime('approved_at');
            
			$table->foreign('creator_user_id')->references('id')->on('jn_core.users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::connection($this->connection)->dropIfExists($this->table);
    }
}