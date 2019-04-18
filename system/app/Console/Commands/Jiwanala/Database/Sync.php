<?php

namespace App\Console\Commands\Jiwanala\Database;

use Illuminate\Console\Command;
use App\Console\Commands\Jiwanala\Database\Compare;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-db:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync database records between Local & Production database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function getConnection($schema, $remote=false){
		return $remote? $this->getRemoteConnection($schema, true) : $this->getLocalConnection($schema);
	}
	
	function getRemoteConnection($schema){ 
		$key = 'remote_'.$schema;
		config(['database.connections.'.$key => [
				'driver' => 	env('DB_REMOTE_DRIVER'),
				'host' => 		env('DB_REMOTE_HOST'),
				'username' => 	env('DB_REMOTE_USERNAME'),
				'password' => 	env('DB_REMOTE_PASSWORD'),
				'database' => 	$schema,
			]]);
		return \DB::connection($key);
	}
	
	function getLocalConnection($schema){ 
		$connections = config('database.connections');
		foreach($connections as $key=>$con){
			if ($con['database'] == $schema){
				return \DB::connection($key);
			}
		}
		return false;
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Artisan::call('jn-db:export',['--remote'=>true], $this->output);
        \Artisan::call('jn-db:refresh',[], $this->output);
		\Artisan::call('jn-db:import',[], $this->output);
    }
}
