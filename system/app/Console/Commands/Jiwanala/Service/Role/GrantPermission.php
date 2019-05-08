<?php

namespace App\Console\Commands\Jiwanala\Service\Role;

use Illuminate\Console\Command;
use App\Libraries\Service\Role;

class GrantPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-role:grant {role_id} {permission_id*}
							{--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant permission to given role';

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
			Role::on($this->remoteConnection('_remotePermission', 'jiwanala_service'))->where('id', $id)->first() : 
			Role::find($id);
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach($this->argument('permission_id') as $permission_id){
			$role = $this->getRole($this->argument('role_id'));
			if ($role){
				$role->permissions()->attach($permission_id);
				$this->line('<fg=cyan>Grant</> Role:<fg=green>'.$role->id.'</> -> Permission:<fg=yellow>'.$permission_id.'</>');
			}
			else{
				$this->error('Role id: '.$this->argument('role_id').' Not Found');
			}
		}
    }
}
