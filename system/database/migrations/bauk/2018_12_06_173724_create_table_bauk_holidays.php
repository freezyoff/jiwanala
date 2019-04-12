<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBaukHolidays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("holidays", function (Blueprint $table) {
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
			$table->increments('id');
			$table->String('name')->comment('nama hari libur');
			$table->date('start')->comment('tanggal mulai libur');
			$table->date('end')->comment('tanggal selesai libur');
			$table->boolean('repeat')->default(0)->comment('diulang setiap bulan yang sama');
			
			$table->foreign('creator')->references('id')->on('jiwanala_service.users');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('holidays');
    }
}
