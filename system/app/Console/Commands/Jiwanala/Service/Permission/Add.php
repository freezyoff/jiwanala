<?php

namespace App\Console\Commands\Jiwanala\Service\Permission;

use Illuminate\Console\Command;
use App\Libraries\Service\Permission;

class Add extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'jn-permission:add {id} {context} {display_name} {description}
							{--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add permission';

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
	
	function createPermission($arg){
		if ($this->isRemote()){
			Permission::on($this->remoteConnection('_remotePermission', 'jiwanala_service'))->insert($arg);
		}
		else{
			Permission::create($arg);
		}
		return $this->getPermission($arg['id']);
	}
	
	function getPermission($id){
		return $this->isRemote()?
			Permission::on($this->remoteConnection('_remotePermission', 'jiwanala_service'))->where('id', $arg['id'])->first() : 
			Permission::find($id);
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $permission = $this->createPermission([
			'id'=>$this->argument('id'),
			'context'=>$this->argument('context'),
			'display_name'=>$this->argument('display_name'),
			'description'=>$this->argument('description')
		]);
		$this->line('<fg=cyan>Add</> Permission Context:<fg=green>'.$permission->context.'</> id:<fg=yellow>'.$permission->id.'</>');
    }
}
