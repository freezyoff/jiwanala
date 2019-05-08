<?php

namespace App\Console\Commands\Jiwanala\Service\Permission;

use Illuminate\Console\Command;
use App\Libraries\Service\Permission;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-permission:sync {--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync permission records in database. Install new Permission if available';

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
	
	function getPermission($id){
		return $this->isRemote()?
			Permission::on($this->remoteConnection('_remotePermission', 'jiwanala_service'))->where('id', $id)->first() : 
			Permission::where('id',$id)->first();
	}
	
	function createPermission($arg){
		return $this->isRemote()?
			Permission::on($this->remoteConnection('_remotePermission', 'jiwanala_service'))->insert($arg) : 
			Permission::create($arg);
	}
	
	function isRemote(){
		return $this->option('remote');
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		foreach(config('permission.permissions') as $key=>$permission){
			$arg = array_combine(['context','display_name','description'], $permission);
			$permission = $this->getPermission($key);
			
			$saved = $permission? true : false;
			if (!$saved){
				$arg['id'] = $key;
				if ($this->isRemote()){
					$arg['--remote'] = true;					
				}
				$this->call('jn-permission:add',$arg,$this->output);
			}
			else{
				$permission->fill($arg);
				$permission->save();
				$this->line('<fg=cyan>'.($saved? 'Sync':'Add ').'</> Permission Context:<fg=green>'.$permission->context.'</> id:<fg=yellow>'.$permission->id.'</>');
			}
		}
    }
}
