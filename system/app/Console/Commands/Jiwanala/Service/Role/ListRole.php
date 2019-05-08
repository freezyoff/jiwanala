<?php

namespace App\Console\Commands\Jiwanala\Service\Role;

use Illuminate\Console\Command;
use App\Libraries\Service\Role;

class ListRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-role:list {--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all Roles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function remoteConnection($connectionKey, $database){
		config(['database.connections.'.$connectionKey => [
			'driver' => 	env('DB_REMOTE_DRIVER'),
			'host' => 		env('DB_REMOTE_HOST'),
			'username' => 	env('DB_REMOTE_USERNAME'),
			'password' => 	env('DB_REMOTE_PASSWORD'),
			'database' => 	$database,
		]]);
		
		return $connectionKey;
	}
	
	function isRemote(){
		return $this->option('remote');
	}
	
	function getRole(){
		return $this->isRemote()?
			Role::on($this->remoteConnection('_remoteRole', 'jiwanala_service'))->get() : 
			Role::all();
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->table(
			['ID','Context', 'Display Name', 'Descriptions'], 
			collect($this->getRole()
				->map(function($item){
					return collect($item)->only(['id','context','display_name','description']);
				}))
		);
    }
}
