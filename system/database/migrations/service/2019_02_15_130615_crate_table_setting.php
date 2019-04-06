<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Libraries\Foundation\Migration;

class CrateTableSetting extends Migration
{
	protected $connection = "service";
	protected $tables = [
		'setting'=>'settings',
	];
	
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		/*
        $this->createSchema(function (Blueprint $table) {
			$table->timestamps();
			$table->integer('creator')->unsigned()->nullable()->comment('ref table service.users');
			$table->string('key');
			$table->text('value');
			$table->string('type',50);
			
			$table->primary('key');
		}, 'setting');
		*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $this->dropSchema('setting');
    }
}
