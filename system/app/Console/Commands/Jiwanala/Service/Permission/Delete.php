<?php

namespace App\Console\Commands\Jiwanala\Service\Permission;

use Illuminate\Console\Command;
use \App\Libraries\Service\Permission;

class Delete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-permission:delete {id*} 
							{--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete registered permission';

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
	
	function getPermission($id){
		return $this->isRemote()?
			Permission::on($this->remoteConnection('_remotePermission', 'jiwanala_service'))->where('id', $id)->first() : 
			Permission::where('id',$id)->first();
	}
	
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach($this->argument('id') as $id){
			if ($permission = $this->getPermission($id)){
				$permission->delete();
				$this->line('<fg=red>Delete</> Permission Context:<fg=green>'.$permission->context.'</> id:<fg=yellow>'.$permission->id.'</>');				
			}
			else{
				$this->line('<fg=yellow>Not Found</> Permission <fg=green>'.$id.'</>');
			}
		}
    }
}
