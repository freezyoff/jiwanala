<?php

namespace App\Console\Commands\Jiwanala\Service\Role;

use Illuminate\Console\Command;
use App\Libraries\Service\Role;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-role:sync 
							{--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Role records in database. Install new Role if available';

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
	
	function createRole($arg){
		if ($this->isRemote()){
			$arg['--remote'] = true;
		}
		$this->call('jn-role:add', $arg);
		return $this->getRole($arg['id']);
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(config('role') as $key=>$role){
			
			$only = ['context','display_name','description'];
			$data = array_filter(
				$role,
				function ($key) use ($only) {
					return in_array($key, $only);
				},
				ARRAY_FILTER_USE_KEY
			);
			
			$dbCurrentRole = $this->getRole($key);
			$exists = $dbCurrentRole? true : false;
			
			if (!$exists){
				$data['id'] = $key;
				$dbCurrentRole = $this->createRole($data);
			}
			$this->line('<fg=cyan>'.($exists? 'Sync' : 'Add ').'</> Role Context:<fg=green>'.
				$dbCurrentRole->context.'</> id:<fg=yellow>'.
				$dbCurrentRole->id.'</>');
			
			//adding permissions 
			$dbCurrentPermissions = [];
			
			//extend from role
			if (isset($role['roles'])){
				foreach($role['roles'] as $extend){
					$dbExtendRole = $this->getRole($extend);
					$dbCurrentPermissions = $dbExtendRole->permissions()->get()
						->flatten(1)
						->map(function($item, $key){
							return $item['id'];
						})->all();
				}				
			}
			
			//handle permissions
			if (isset($role['permissions'])){
				foreach($role['permissions'] as $permission){
					if (!in_array($permission, $dbCurrentPermissions)){
						$dbCurrentPermissions[] = $permission;
					}
				}
			}
			
			//insert
			$dbCurrentRole->permissions()->sync($dbCurrentPermissions);
			foreach($dbCurrentPermissions as $permission){
				$this->line('<fg=cyan>'.($exists? 'Sync':'Add ').'</> Role:<fg=green>'.$dbCurrentRole->id.'</> -> Permission:<fg=yellow>'.$permission.'</>');
			}
		}
    }
}
