<?php

namespace App\Console\Commands\Jiwanala\Service\Role;

use Illuminate\Console\Command;
use App\Libraries\Service\Role;

class Delete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-role:delete {id*}
							{--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Role for given id';

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
	
	function getRole($id){
		return $this->isRemote()?
			Role::on($this->remoteConnection('_remoteRole', 'jiwanala_service'))->where('id', $id)->first() : 
			Role::find($id);
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach($this->argument('id') as $id){
			$role = $this->getRole($id);
			if ($role){
				$role->delete();
				$this->line('<fg=red>Delete</> Role Context:<fg=green>'.$role->context.'</> id:<fg=yellow>'.$role->id.'</>');
			}
			else{
				$this->line('<fg=yellow>Not Found</> Role <fg=green>'.$role->id.'</>');
			}
		}
    }
}
