<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JNACCOUNTINGCreateAccountBalancesTable extends Migration
{
    protected $connection = 'jn_accounting';
	protected $table = 'account_balances';
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
		Schema::connection($this->connection)->create($this->table, function (Blueprint $table) {
            $table->timestamps();
            $table->increments('id');
            $table->integer('account_id')->unsigned();
			$table->double('balance');
			$table->integer('periode')->comment('Periode/bulan tutup buku: 1-12');
			$table->text('memo');
			
			$table->foreign('account_id')->references('id')->on('jn_accounting.accounts');
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
