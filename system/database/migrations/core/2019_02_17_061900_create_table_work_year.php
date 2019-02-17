<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableWorkYear extends Migration
{
	protected $connection = "core";
	protected $tables = [
		"work-year"=>"work_year",
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
            $table->increments('id');
			$table->string('name', 50);
			$table->date('start');
			$table->date('end');
        },'work-year');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('work-year');
    }
}
