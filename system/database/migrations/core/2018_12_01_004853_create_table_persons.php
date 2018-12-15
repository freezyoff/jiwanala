<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTablePersons extends Migration
{
	protected $connection = "core";
	protected $tables = 'persons';
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		$this->createSchema(function (Blueprint $table) {
            $table->integer('creator')->unsigned()->nullable();
            $table->timestamps();
			$table->increments('id');
			$table->string('kk',20)->nullable()->comment('Nomor Kartu Keluarga / KK');
            $table->string('nik',25)->unique()->comment('Nomor Induk Kependudukan / Nomor KTP');
            $table->string('name_front_titles', 50)->nullable();
            $table->string('name_full', 100);
            $table->string('name_back_titles', 50)->nullable();
            $table->string('birth_place', 50)->nullable();
            $table->date('birth_date')->nullable();
			$table->enum('gender', ['l', 'p']);
            $table->enum('marital',['bm','mn','cr','mt'])->comment('bm: belum menikah, mn:menikah, dj: duda/janda cerai, mt: duda/janda mati')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $this->dropSchema();
    }
}
