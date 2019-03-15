<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CreateTableJobPositions extends Migration
{
    protected $connection = "core";
	protected $tables = [
		"job-position"=>"job_positions",
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
			$table->integer('creator')->unsigned()->nullable()->comment('foreign service.users');
			$table->string('code',20);
			$table->string('name');
			$table->string('alias');
			
			$table->primary('code');
        }, 'job-position');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropSchema('job-position');
    }
}
