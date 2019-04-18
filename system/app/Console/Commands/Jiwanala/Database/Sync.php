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
    protected $signature = 'jn-db:sync 
							{--remote	: sync remote database records with local database records}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync database records between Local & Production database or vice versa';

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
		if ($this->option('remote')){
			//export local database
			\Artisan::call('jn-db:export',[], $this->output);
			//truncate remote databse
			\Artisan::call('jn-db:truncate',['--remote'=>true], $this->output);
			//seed remote database with latest export
			\Artisan::call('jn-db:import',['--remote'=>true], $this->output);
		}
		else{
			//export remote database
			\Artisan::call('jn-db:export',['--remote'=>true], $this->output);
			//truncate local database
			\Artisan::call('jn-db:truncate',[], $this->output);
			//seed local database with lates export
			\Artisan::call('jn-db:import',[], $this->output);
		}
		
    }
}
