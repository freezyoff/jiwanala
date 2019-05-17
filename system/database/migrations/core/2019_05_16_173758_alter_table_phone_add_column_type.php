<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePhoneAddColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("phones", function (Blueprint $table) {
			$table->enum('type',['m','h','w'])
				->after('default')
				->default('m')
				->comment('h:home, w:work, m:mobile');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("phones", function (Blueprint $table) {
			$table->dropColumn('type');
		});
    }
}
