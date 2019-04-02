<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('jiwanala-test', function(){
	$connections = ['service', 'core', 'bauk'];
	foreach($connections as $connection){
		
		//get table list in schema
		$tables = \DB::connection($connection)->select('SHOW TABLES');
		
		//alter the table
		foreach($tables as $table){
			foreach($table as $key=>$tableName){
				$schema = config('database.connections.'.$connection.'.database');
				\DB::select('ALTER TABLE `'.$schema.'`.`'.$tableName.'` ENGINE = "InnoDB"');
				$this->info('alter to InnoDB: '.$connection.'.'.$tableName);
			}
		}
	}
});
