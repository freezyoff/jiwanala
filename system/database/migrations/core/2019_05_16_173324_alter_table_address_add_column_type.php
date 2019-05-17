<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddressAddColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("addresses", function (Blueprint $table) {
			$table->enum('type',['h','w'])
				->after('default')
				->default('h')
				->comment('h:home, w:work');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table("addresses", function (Blueprint $table) {
			$table->dropColumn('type');			
		});
    }
}
