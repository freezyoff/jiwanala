<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDivisionAddColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('divisions', function(Blueprint $table){
			$table->enum('type',['ed','sp'])->comment('ed: education division, sp: support division');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('divisions', function(Blueprint $table){
			$table->dropColumn('type');
		});
    }
}
